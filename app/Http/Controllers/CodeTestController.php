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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $exer_logs = ExerciseCodeLog::where("user_id", Auth::id())->where("question_id", $course_id)->orderBy('id','DESC')->get();

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
            'exercise_logs'=> $exer_logs,
            'explain'      => $explain,
            'essay'        => $essay
        ]);
    }

    public function codeTestSubmit(Request $request)
    {
        try{
            $model = UserScore::where("user_id", $request->get("user_id"))->where("question_id", $request->get("question_id"));
            $question = Question::find($request->get("question_id"));
            $check_explain = Explains::where("user_id", $request->get("user_id"))->where('question_id', $request->get("question_id"));
            Log::debug($model->count());
            if($request->score > 0){
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
                } else{
                    $check = UserScore::where("user_id", $request->get("user_id"))->where("question_id", $request->get("question_id"))->first();
                    $user_score = UserScore::firstwhere('id', $check->id);
                    // $user_score->score = $request->get('score');
                    $user_score->score = $request->get('score') == 10 ? $question->score : 0;
                    $user_score->save();
                }
                
                $jawaban = $request->input('answer');
                $pertanyaanId = $request->input('essay_id');

                foreach ($pertanyaanId as $key => $id_essay) {
                    $answer = $jawaban[$key];
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
                            $data_explain-> answer = $answer;
                            $data_explain->save();
                        }
                    }
                }


                // if($check_explain->count() == 0){
                //     Explains::create(
                //         [
                //             "user_id" => $request->get("user_id"),
                //             "question_id" => $request->get("question_id"),
                //             "description"   => $request->get("code_explain"),
                //             "level_id"      => $request->get('level_id'),
                //             "code"          => 1
                //         ]
                //         );
                // } else{
                //     $explain = Explains::firstwhere('id', $check_explain->first()->id);
                //     $explain -> description = $request->get("code_explain");

                //     $explain->save();
                // }
                return response()->json([
                    'status'    => '200',
                    'message'   => 'Success add user score'
                ],200);
            } else{
                return response()->json([
                    'status'    => '500',
                    'message'   => 'Error add user',
                ],500);
            }
        } catch(Exception $err){
            return response()->json([
                'status'    => '500',
                'message'   => 'Error add score',
            ],500);
        }
        
    }
}