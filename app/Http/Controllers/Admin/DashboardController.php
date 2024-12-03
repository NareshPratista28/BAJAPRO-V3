<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BadgeSetting;
use App\Models\User;
use App\Models\WonderingScore;
use App\Models\Question;
use App\Models\Content;
use App\Models\EssayQuestion;
use App\Models\UserAnswer;
use App\Models\UserScore;
use App\Models\TotalScore;
use App\Models\ExplainingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function leaderboard()
    {
        $user_id = User::where('role_id', 2)->get();
        $data = [];

        foreach ($user_id as $user) {
            $wondering = WonderingScore::where(["user_id" => $user->id])->sum("score");
            $exploring = UserScore::where("user_id", $user->id)->sum("score");
            $explainKonteks = ExplainingScore::where("user_id", $user->id)->sum("konteks_penjelasan");
            $explainBenar = ExplainingScore::where("user_id", $user->id)->sum("kebenaran");
            $explainKeruntutan = ExplainingScore::where("user_id", $user->id)->sum("keruntutan");
            $final_score = $wondering + $exploring +  $explainKonteks + $explainBenar + $explainKeruntutan;
            $current_badge = BadgeSetting::where("min", "<=", $final_score)->where("max", ">=", $final_score)->first();

            $data[] = [
                'user' => $user,
                'final_score' => $final_score,
                'current_badge' => $current_badge,
            ];
        }

        $data = collect($data)->sortByDesc('final_score')->values()->all();

        if (Auth::user()->role_id == 1) {
            return view('admin.dashboard.leaderboard', compact('data'));
        } else if (Auth::user()->role_id == 2) {
            return view('student_courses.leaderboard_student', compact('data'));
        }
    }

    public function report($user_id = null)
    {

        $users = User::all();

        if (!empty($user_id)) {
            $user_score = UserScore::where(["user_id" => $user_id])->get();
            $take = UserScore::where("user_id", $user_id)->pluck("question_id")->toArray();
            $code_test_score = UserScore::where(["user_id" => $user_id])->whereNotNull("question_id")->get();
            $wondering = WonderingScore::where(["user_id" => $user_id])->sum("score");
            $exploring = UserScore::where("user_id", $user_id)->sum("score");
            $explainKonteks = ExplainingScore::where("user_id", $user_id)->sum("konteks_penjelasan");
            $explainBenar = ExplainingScore::where("user_id", $user_id)->sum("kebenaran");
            $explainKeruntutan = ExplainingScore::where("user_id", $user_id)->sum("keruntutan");
            $final_score = $wondering + $exploring +  $explainKonteks + $explainBenar + $explainKeruntutan;
            $current_badge = BadgeSetting::where("min", "<=", $final_score)->where("max", ">=", $final_score)->first();

            return view("admin.dashboard.report", [
                "score" => $user_score,
                "current_badge" => $current_badge,
                "percentage" => UserScore::getPercentage($user_id),
                "finish_code_tests" => $take,
                "user_id" => $user_id,
                "users" => $users,
                "code_score" => $code_test_score,
                "final_score"   => $final_score
            ]);
        }

        return view('admin.dashboard.report', ["user_id" => $user_id, 'users' => $users]);
    }

    public function penilaian($user_id, $content_id)
    {
        $user = User::firstwhere('id', $user_id);
        $content = Content::where('id', $content_id)->first();
        $read = WonderingScore::where('user_id', $user_id)->where('content_id', $content_id)->first();
        $coding = UserScore::where('user_id', $user_id)->where('content_id', $content_id)->first();
        $question = Question::where('content_id', $content_id)->first();
        $question_id = Question::where('content_id', $content_id)->pluck('id');
        $essay = EssayQuestion::whereIn('question_id', $question_id)->pluck('id');
        $answer = UserAnswer::whereIn('essay_question_id', $essay)->where('user_id', $user_id)->get();

        $explain_score = ExplainingScore::where('content_id', $content_id)->where('question_id', $question_id)->where('user_id', $user_id)->get();
        $isAccepted = ExplainingScore::where('content_id', $content_id)
            ->where('question_id', $question_id)
            ->where('user_id', $user_id)
            ->get()
            ->pluck('is_accepted');


        if ($explain_score->count() > 0) {
            $total = $explain_score->sum(function ($explain_score) {
                return $explain_score->keruntutan + $explain_score->kebenaran + $explain_score->konteks_penjelasan;
            });


            foreach ($explain_score as $index => $item) {

                // $isAcceptedKonteks = $explain_score[0]->is_accepted;
                // $isAcceptedRuntut = $explain_score[1]->is_accepted;
                // $isAcceptedKebenaran = $explain_score[2]->is_accepted;

                $convertKonteks = $explain_score[0]->konteks_penjelasan;
                $convertRuntut = $explain_score[1]->keruntutan;
                $convertKebenaran = $explain_score[2]->kebenaran;

                $id_konteks = $explain_score[0]->id;
                $id_runtut = $explain_score[1]->id;
                $id_benar = $explain_score[2]->id;

                $konteks = $this->reverseConvert($convertKonteks);
                $benar = $this->reverseConvert($convertKebenaran);
                $runtut = $this->reverseConvert($convertRuntut);
            };
            // dd([$konteks, $benar, $runtut]);

            return view('admin.dashboard.penilaian', compact('user', 'read', 'coding', 'essay', 'answer', 'content', 'question', 'explain_score', 'total', 'konteks', 'runtut', 'benar', 'id_benar', 'id_runtut', 'id_konteks', 'convertKonteks', 'convertRuntut', 'convertKebenaran', 'isAccepted'));
        } else {
            return view('admin.dashboard.penilaian', compact('user', 'read', 'coding', 'essay', 'answer', 'content', 'question', 'explain_score'));
        }
    }

    public function reverseConvert($value)
    {
        switch ($value) {
            case 3:
                return 1;
            case 5:
                return 2;
            case 10:
                return 3;
            case 15:
                return 4;
            case 20:
                return 5;
            default:
                return $value;
        }
    }

    public function addPenilaian(Request $request)
    {

        try {

            $check_explain = ExplainingScore::where('content_id', $request->content_id)->where('question_id', $request->question_id)->where('user_id', $request->user_id);

            if ($check_explain->count() == 0) {
                $total_score = TotalScore::create([
                    'content_id'        => $request->content_id,
                    'user_id'           => $request->user_id,
                    'question_id'       => $request->question_id,
                    'score'             => $request->tot_score,
                    'wondering_score_id' => $request->wondering_id,
                    'user_score_id'     => $request->exploring_id
                ]);

                $explainKonteks = ExplainingScore::create([
                    'total_score_id'    => $total_score->id,
                    'content_id'        => $request->content_id,
                    'user_id'           => $request->user_id,
                    'question_id'       => $request->question_id,
                    'konteks_penjelasan' => $request->ikonteks,
                    'essay_question_id' => $request->essay_question_konteks,
                    'user_answer_id'    => $request->user_answer_konteks
                ]);

                $explainRuntut = ExplainingScore::create([
                    'total_score_id'    => $total_score->id,
                    'content_id'        => $request->content_id,
                    'user_id'           => $request->user_id,
                    'question_id'       => $request->question_id,
                    'keruntutan'        => $request->iruntut,
                    'essay_question_id' => $request->essay_question_runtut,
                    'user_answer_id'    => $request->user_answer_runtut
                ]);

                $explainBenar = ExplainingScore::create([
                    'total_score_id'    => $total_score->id,
                    'content_id'        => $request->content_id,
                    'user_id'           => $request->user_id,
                    'question_id'       => $request->question_id,
                    'kebenaran'         => $request->ibenar,
                    'essay_question_id' => $request->essay_question_kebenaran,
                    'user_answer_id'    => $request->user_answer_kebenaran

                ]);
            } else {
                $check_total = $check_explain->first()->total->id;

                $total_score = TotalScore::findOrFail($check_total);
                $total_score->score = $request->tot_score;
                $total_score->save();                

                $konteks = ExplainingScore::firstwhere('id', $request->id_konteks);
                $konteks->konteks_penjelasan = $request->ikonteks;
                $konteks->is_accepted = ($request->acc == 'true'); 
                $konteks->save();

                $runtut = ExplainingScore::firstwhere('id', $request->id_runtut);
                $runtut->keruntutan = $request->iruntut;
                $runtut->is_accepted = ($request->acc == 'true'); 
                $runtut->save();

                $benar = ExplainingScore::firstwhere('id', $request->id_benar);
                $benar->kebenaran = $request->ibenar;
                $benar->is_accepted = ($request->acc == 'true'); 
                $benar->save();
            }

            return response()->json([
                'status'    => '200',
                'message'   => 'Success add user score'
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status'    => '500',
                'message'   => 'Error add score',
            ], 500);
        }
    }

}
