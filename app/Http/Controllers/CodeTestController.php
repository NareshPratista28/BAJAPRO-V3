<?php

namespace App\Http\Controllers;

use App\Models\ErrorCodeLog;
use App\Models\Question;
use App\Models\UserCodeTestScore;
use App\Models\UserScore;
use App\Models\ExerciseCodeLog;
use App\Models\EssayQuestion;
use App\Models\UserAnswer;
use App\Models\Level;
use App\Models\ExplainingScore;
use App\Models\Explains;
use App\Models\TotalScore;
use App\Models\WonderingScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CodeTestController extends Controller
{
    //
    public function index($course_id, Request $request)
    {
        $question = Question::find($course_id);
        $score = UserScore::where("user_id", Auth::id())->where("question_id", $course_id);
        $explain = Explains::where("user_id", Auth::id())->where('question_id', $course_id)->get();
        // $data_essay = UserAnswer::where('user_id', Auth::id())
        // $level = Level::firstwhere('id',$request->level_id);
        // dd([Auth::id(), $course_id, $explain]);
        $essay = EssayQuestion::where('question_id', $course_id)->get();
        $duration  = "";

        $user_score = $score->first();
        $err_logs = ErrorCodeLog::where("user_id", Auth::id())->where("question_id", $course_id)->get();
        $exer_logs = ExerciseCodeLog::where("user_id", Auth::id())->where("question_id", $course_id)->orderBy('id', 'DESC')->get();

        if ($user_score) {
            $a = Carbon::parse($user_score->started_at);
            $b = Carbon::parse($user_score->ended_at);
            $duration = $b->diff($a)->format('%Hh %Im %Ss');
        }

        $isFinish = false;
        if ($score->count() > 0) {
            $isFinish = true;
        }

        return view("student_courses.code_test", [
            "question" => $question,
            'score' => $score->sum('score'),
            'is_finish' => $isFinish,
            'user_score' => $user_score,
            'duration' => $duration,
            'error_logs' => $err_logs,
            'exercise_logs' => $exer_logs,
            'explain'      => $explain,
            'essay'        => $essay
        ]);
    }

    public function codeTestSubmit(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = UserScore::where("user_id", $request->get("user_id"))->where("question_id", $request->get("question_id"));
            $question = Question::find($request->get("question_id"));
            $check_explain = Explains::where("user_id", $request->get("user_id"))->where('question_id', $request->get("question_id"));
            Log::debug($model->count());
            if ($request->score > 0) {
                if ($model->count() == 0) {
                    UserScore::create(
                        [
                            "user_id" => $request->get("user_id"),
                            "question_id" => $request->get("question_id"),
                            "content_id" => $request->get("content_id"),
                            "score" => $request->get('score') == 10 ? $question->score : 0,
                            "started_at" => $request->get("started_at"),
                            "ended_at" => $request->get("ended_at"),
                            "on_timer" => $request->get("on_timer"),
                            "level_id"  => $request->get('level_id')
                        ]
                    );
                } else {
                    $check = UserScore::where("user_id", $request->get("user_id"))->where("question_id", $request->get("question_id"))->first();
                    $user_score = UserScore::firstwhere('id', $check->id);
                    // $user_score->score = $request->get('score');
                    $user_score->score = $request->get('score') == 10 ? $question->score : 0;
                    $user_score->save();
                }

                $jawaban = $request->input('answer');
                $pertanyaanId = $request->input('essay_id');

                $nilai = [];
                foreach ($pertanyaanId as $key => $id_essay) {
                    $answer = $jawaban[$key]; // user answere
                    $essayAnswer = EssayQuestion::find($id_essay)->answer;
                    $check_data = UserAnswer::where('user_id', Auth::id())->where('essay_question_id', $id_essay);
                    if($check_data->count() == 0){
                        UserAnswer::create([
                            'user_id'   => Auth::id(),
                            'essay_question_id'=> $id_essay,
                            'answer'    => $answer
                        ]);
                    } else {
                        $check_rubrik = ExplainingScore::where('user_id', Auth::id())->where('user_answer_id', $check_data->first()->id)->count();
                        if ($check_rubrik == 0){
                            $data_explain = UserAnswer::firstwhere('id', $check_data->first()->id);
                            $data_explain->answer = $answer;
                            $data_explain->save();
                        }
                    }

                    try {
                        $response = Http::asForm()->post(env("GENERATE_GRADE_URL", "http://127.0.0.1:8000/compiler/generate/grade"), [
                            'esay_answer' => $answer,
                            'user_answer' => $essayAnswer
                        ]);
                        $data = $response->json(); // $data['output'] | 0 - 1
                        $nilai[] = $this->convertNilai($data['output']);
                    } catch (Exception $err) {
                        return response()->json([
                            'status'    => '500',
                            'message'   => 'Error add score',
                        ], 500);
                    }
                }

                $check_explain = ExplainingScore::where('content_id', $request->content_id)->where('question_id', $request->question_id)->where('user_id', $request->user_id);
                $wondering = WonderingScore::where('content_id', $request->content_id)->where('user_id', $request->user_id)->first();
                $user_score = UserScore::where('content_id', $request->content_id)->where('user_id', $request->user_id)->where('question_id', $request->question_id)->first();

                $tot_score = $wondering->score + $user_score->score + $nilai[0] + $nilai[1] + $nilai[2];
                if($check_explain->count() == 0){
                    $total_score = TotalScore::create([
                        'content_id'        => $request->content_id,
                        'user_id'           => $request->user_id,
                        'question_id'       => $request->question_id,
                        'score'             => $tot_score,
                        'wondering_score_id'=> $wondering->id,
                        'user_score_id'     => $user_score->id
                    ]);
        
                    $konteksAnswer = UserAnswer::where('user_id', $request->user_id)->where('essay_question_id', $request->essay_id[0])->first();
                    $explainKonteks = ExplainingScore::create([
                        'total_score_id'    => $total_score->id,
                        'content_id'        => $request->content_id,
                        'user_id'           => $request->user_id,
                        'question_id'       => $request->question_id,
                        'konteks_penjelasan'=> $nilai[0],
                        'essay_question_id' => $request->essay_id[0],
                        'user_answer_id'    => $konteksAnswer->id
                    ]);
            
                    $runtutAnswer = UserAnswer::where('user_id', $request->user_id)->where('essay_question_id', $request->essay_id[1])->first();
                    $explainRuntut = ExplainingScore::create([
                        'total_score_id'    => $total_score->id,
                        'content_id'        => $request->content_id,
                        'user_id'           => $request->user_id,
                        'question_id'       => $request->question_id,
                        'keruntutan'        => $nilai[1],
                        'essay_question_id' => $request->essay_id[1],
                        'user_answer_id'    => $runtutAnswer->id
                    ]);
            
                    $benarAnswer = UserAnswer::where('user_id', $request->user_id)->where('essay_question_id', $request->essay_id[2])->first();
                    $explainBenar = ExplainingScore::create([
                        'total_score_id'    => $total_score->id,
                        'content_id'        => $request->content_id,
                        'user_id'           => $request->user_id,
                        'question_id'       => $request->question_id,
                        'kebenaran'         => $nilai[2],
                        'essay_question_id' => $request->essay_id[2],
                        'user_answer_id'    => $benarAnswer->id
                    ]);
                } else{
                    $check_total = $check_explain->first()->total->id;

                    $check_explain = ExplainingScore::where('content_id', $request->content_id)->where('question_id', $request->question_id)->where('user_id', $request->user_id);
    
                    $total_score = TotalScore::firstwhere('id', $check_total);
                    $total_score->score = $tot_score;
                    $total_score->save();
    
                    $konteks = ExplainingScore::firstwhere('id', $check_explain->get()[0]->id);
                    $konteks->konteks_penjelasan = $nilai[0];
                    $konteks->save();
    
                    $runtut = ExplainingScore::firstwhere('id', $check_explain->get()[1]->id);
                    $runtut->keruntutan = $nilai[1];
                    $runtut->save();
    
                    $benar = ExplainingScore::firstwhere('id', $check_explain->get()[2]->id);
                    $benar->kebenaran = $nilai[2];
                    $benar->save();
                }
                DB::commit();

                return response()->json([
                    'status'    => '200',
                    'message'   => 'Success add user score',
                    'data'      => $data
                ], 200);
            } else {
                return response()->json([
                    'status'    => '500',
                    'message'   => 'Error add user',
                ], 500);
            }
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json([
                'status'    => '500',
                'message'   => 'Error add score',
            ], 500);
        }
    }

    private function convertNilai($value){
        if($value > 0 && $value <= 0.2){
            return 3;
        } else if($value > 0.2 && $value <= 0.4){
            return 5;
        } else if($value > 0.4 && $value <= 0.6){
            return 10;
        } else if($value > 0.6 && $value <= 0.8){
            return 15;
        } else if($value > 0.8 && $value <= 1.0){
            return 20;
        }
    }
}
