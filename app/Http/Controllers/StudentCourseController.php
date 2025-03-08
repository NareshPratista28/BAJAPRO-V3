<?php

namespace App\Http\Controllers;

use App\Models\BadgeSetting;
use App\Models\Content;
use App\Models\Course;
use App\Models\EssayQuestion;
use App\Models\Question;
use App\Models\StudentCourse;
use App\Models\User;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\UserScore;
use App\Models\WonderingScore;
use App\Models\ExplainingScore;
use App\Models\TotalScore;
use App\Models\Explains;
use App\Models\ExerciseCodeLog;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class StudentCourseController extends Controller
{
    //

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $student_courses = Course::select(["courses.id", "courses.course_name", "courses.description"])
                ->join("student_courses", "courses.id", "=", "student_courses.course_id")
                ->where("student_courses.user_id", $user_id)->get();
            return view("student_courses.index", ["studentCourses" => $student_courses]);
        }
    }

    public function detail($course_id)
    {
        $course = Course::find($course_id);
        $total_score = UserScore::where("user_id", Auth::id())->sum("score");
        $current_badge = BadgeSetting::all();
        $fullbadge = BadgeSetting::all();
        $getBadge = "(SELECT badge_settings.name FROM badge_settings WHERE badge_settings.min <= 'total_score' and badge_settings.max >= 'total_score' LIMIT 1)";

        $getBadgeFile = "(SELECT badge_settings.file FROM badge_settings WHERE badge_settings.min <= 'total_score' and badge_settings.max >= 'total_score' LIMIT 1)";
        $leader_board = UserScore::select(DB::raw("user_id, SUM(score) as total_score, $getBadge as badge_name, $getBadgeFile as file"))->groupBy("user_id")->orderBy("total_score", "DESC")->get();

        $question = Question::where("is_essay", "1")->pluck("id");

        $lboard = [];
        foreach ($leader_board as $key => $lead) {
            $answeredQues = UserScore::where("user_id", $lead->user_id)->whereIn("question_id", $question)->count();
            $percentage = number_format((float)$answeredQues / $question->count() * 100, 1, '.', '');

            $badge = BadgeSetting::where("min", "<=", $lead->total_score)->where("max", ">=", $lead->total_score)->first();

            $lboard[$key]['user'] = User::find($lead->user_id)->name;
            $lboard[$key]['total_score'] = $lead->total_score;
            $lboard[$key]['percentage'] = $percentage;
            $lboard[$key]['badge_name'] = $badge->name;
            $lboard[$key]['file'] = $badge->file;
            $lboard[$key]['answered_question'] = $answeredQues;
            $lboard[$key]['code_questions'] = $question->count();
        }

        return view("student_courses.detail", [
            "course" => $course,
            "total_score" => $total_score,
            "current_badge" => $current_badge,
            "leader_board" => $lboard
        ]);
    }
    public function takeCourse(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $check_course = StudentCourse::where(["user_id" => $user_id, "course_id" => $request["course_id"]]);
            if ($check_course->count() == 0) {
                $student_course = StudentCourse::create(["user_id" => $user_id, "course_id" => $request["course_id"]]);
                if ($student_course->save()) {
                    session()->flash('msg_error1', 'You take it success');
                    return redirect()->back();
                }
            } else {
                session()->flash('msg_error', 'You already take it');
                return redirect()->back();
            }
        }
    }

    public function my_course($course_id, $level_id, $content_id = null)
    {
        if ($content_id == 1) {
            $check = WonderingScore::where('user_id', Auth::id())->where('content_id', $content_id);
            if ($check->count() == 0) {
                WonderingScore::create([
                    'user_id' => Auth::id(),
                    'content_id' => $content_id,
                    'score' => 10,
                ]);
            }
        }
        $course = Course::find($course_id);
        $level = Level::find($level_id);
        $contents = $content_id != null ? Content::find($content_id) : $level->lessons[0]->contents->first();
        // $user_score = UserScore::where(["content_id" => $content_id == null ? $contents->id : $content_id, "user_id" => Auth::id()])->first();
        $user_score = TotalScore::where(["content_id" => $content_id == null ? $contents->id : $content_id, "user_id" => Auth::id()])->first();

        $wondering = WonderingScore::where(["user_id" => Auth::id()])->sum("score");
        $exploring = UserScore::where("user_id", Auth::id())->sum("score");
        $explainKonteks = ExplainingScore::where("user_id", Auth::id())->sum("konteks_penjelasan");
        $explainBenar = ExplainingScore::where("user_id", Auth::id())->sum("kebenaran");
        $explainKeruntutan = ExplainingScore::where("user_id", Auth::id())->sum("keruntutan");
        $final_score = $wondering + $exploring +  $explainKonteks + $explainBenar + $explainKeruntutan;
        $current_badge = BadgeSetting::where("min", "<=", $final_score)->where("max", ">=", $final_score)->first();

        $active_lesson = $content_id != null ? Content::find($content_id)->lesson : $level->lessons->first();
        $questions = Question::where(["is_essay" => "0", "content_id" => $content_id])->get();
        $code_test = Question::where(["is_essay" => "1", "content_id" => $content_id])->get();
        $take = UserScore::where("user_id", Auth::id())->pluck("question_id")->toArray();

        $check_read = WonderingScore::where(["user_id" => Auth::id()])->where('content_id', $content_id)->count();

        $is_last = 0;
        $check_explain = 0;
        if ($content_id != null) {
            $last_lesson = Lesson::where('level_id', $level_id)->orderBy('position', 'Desc')->first();
            $content = Content::where('lesson_id', $last_lesson->id)->pluck('id')->toArray();
            $last_question = Question::whereIn('content_id', $content)->pluck('id')->toArray();

            $last_content = max($content);
            $history_question = UserScore::where('user_id', Auth::id())->whereIn('content_id', $content)->pluck('question_id')->toArray();
            $check_explain = Explains::where("user_id", Auth::id())->where('level_id', $level_id)->where('code', 0)->count();
            $check_question = array_diff($last_question, $history_question);
            if (empty($check_question) && $last_content == $content_id) {
                $is_last = 1;
            }
        }

        // $tanya = Question::where('content_id', 7)->pluck('id')->toArray();

        // $check = UserScore::where('user_id', Auth::user()->id)->where('content_id', 7)->orderBy('question_id', 'asc')->pluck('question_id')->toArray();
        // $different = array_diff($tanya, $check);
        // if(empty($different)){
        //     $pass = 1;
        // } else{
        //     $pass =0;
        // }
        // dd([$tanya, $check, $pass]);
        //active_lesson untuk melihat course yang dibuka saat ini
        return view("student_courses.my_course", [
            "level" => $level,
            "course" => $course,
            "content" => $contents,
            "score" => $user_score,
            "final_score" => $final_score,
            "active_lesson" => $active_lesson,
            "active_content" => $contents,
            "current_badge" => $current_badge,
            "questions" => $questions,
            "code_tests" => $code_test,
            "percentage" => UserScore::getPercentage(),
            "finish_code_tests" => $take,
            "is_last"   => $is_last,
            "check_explain" => $check_explain,
            "check_read"    => $check_read
        ]);
    }

    public function report()
    {
        $user_score = UserScore::where(["user_id" => Auth::id()])->get();
        $take = UserScore::where("user_id", Auth::id())->pluck("question_id")->toArray();
        $code_test_score = UserScore::where(["user_id" => Auth::id()])->whereNotNull("question_id")->get();
        $wondering = WonderingScore::where(["user_id" => Auth::id()])->sum("score");
        $exploring = UserScore::where("user_id", Auth::id())->sum("score");
        $explainKonteks = ExplainingScore::where("user_id", Auth::id())->sum("konteks_penjelasan");
        $explainBenar = ExplainingScore::where("user_id", Auth::id())->sum("kebenaran");
        $explainKeruntutan = ExplainingScore::where("user_id", Auth::id())->sum("keruntutan");
        $final_score = $wondering + $exploring +  $explainKonteks + $explainBenar + $explainKeruntutan;
        $current_badge = BadgeSetting::where("min", "<=", $final_score)->where("max", ">=", $final_score)->first();

        // $his_error = ExerciseCodeLog::where()
        // $his_success = ExerciseCodeLog::where

        return view("student_courses.report", [
            "score" => $user_score,
            "final_score" => $final_score,
            "current_badge" => $current_badge,
            "percentage" => UserScore::getPercentage(),
            "finish_code_tests" => $take,
            "code_score" => $code_test_score,
        ]);
    }

    public function detailReport($question_id)
    {
        $user_id = Auth::id();
        $question = Question::find($question_id);
        // $score = UserScore::where("user_id", Auth::id())->where("question_id", $question_id)->first();
        $score = TotalScore::where("user_id", Auth::id())->where("question_id", $question_id)->first();
        $wondering = WonderingScore::where(["user_id" => Auth::id()])->sum("score");
        $exploring = UserScore::where("user_id", Auth::id())->sum("score");
        $explainKonteks = ExplainingScore::where("user_id", Auth::id())->sum("konteks_penjelasan");
        $explainBenar = ExplainingScore::where("user_id", Auth::id())->sum("kebenaran");
        $explainKeruntutan = ExplainingScore::where("user_id", Auth::id())->sum("keruntutan");
        $final_score = $wondering + $exploring +  $explainKonteks + $explainBenar + $explainKeruntutan;
        $exercise_logs = ExerciseCodeLog::where("user_id", Auth::id())->where("question_id", $question_id)->orderBy('id', 'DESC')->get();

        $essay = EssayQuestion::where('question_id', $question_id)->pluck('id');
        $explain = UserAnswer::whereIn('essay_question_id', $essay)->where('user_id', $user_id)->get();
        $title = "code";

        return view("student_courses.detail_report", compact('exercise_logs', 'score', 'question', 'explain', 'title', 'final_score'));
    }

    public function level($course_id)
    {
        $level = Level::where('course_id', $course_id)->get();
        $l = Level::firstwhere('id', 2);
        //isi level 1
        $level_down = $l->id - 1;
        $lessons1 = Lesson::where('level_id', $level_down)->pluck('id');
        $content1 = Content::whereIn('lesson_id', $lessons1)->pluck('id');
        $question1 = Question::whereIn('content_id', $content1)->pluck('id')->toArray();


        $check = UserScore::where('user_id', Auth::user()->id)->where('level_id', $level_down)->orderBy('question_id', 'asc')->pluck('question_id')->toArray();

        return view("student_courses.level", compact('level', 'course_id'));
    }

    public function readScore(Request $request)
    {
        try {

            $content_id = $request->input('content_id');
            $check = WonderingScore::where('user_id', Auth::id())->where('content_id', $content_id);
            if ($check->count() == 0) {
                WonderingScore::create([
                    'user_id'   => Auth::id(),
                    'content_id'    => $content_id,
                    'score'         => 10,
                ]);
            }

            return response()->json([
                'status'    => '200',
                'message'   => 'Success add score',
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status'    => '500',
                'message'   => 'Error add score',
            ], 500);
        }
    }
}
