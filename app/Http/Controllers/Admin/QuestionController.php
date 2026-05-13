<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Answer;
use App\Models\EssayQuestion;
use App\Models\UserAnswer;
use App\Models\UserScore;
use App\Repositories\QuestionRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Response;

class QuestionController extends AppBaseController
{
    /** @var QuestionRepository $questionRepository*/
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepo)
    {
        $this->questionRepository = $questionRepo;
    }

    /**
     * Display a listing of the Question.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $questions = $this->questionRepository->paginate(10);

        return view('admin.questions.index')
            ->with('questions', $questions);
    }

    /**
     * Show the form for creating a new Question.
     *
     * @return Response
     */
    public function create()
    {
        $title = "create";
        $contents = Content::all()->pluck("title", "id");
        return view('admin.questions.create', ["contents" => $contents, "answers" => [], "title" => $title]);
    }

    /**
     * Store a newly created Question in storage.
     *
     * @param CreateQuestionRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            Log::info('🔄 Question store request received', [
                'content_id' => $request->input('content_id'),
                'question_name' => $request->input('question_name'),
                'has_junit_tests' => !empty($request->input('junit_tests')),
                'is_ajax' => $request->ajax()
            ]);

            $input = $request->all();

            // Handle database-driven JUnit data - simpan langsung ke database
            if ($request->has('test_cases_data')) {
                $input['test_cases_data'] = $request->input('test_cases_data');
                Log::info('📊 Test cases data received');
            }

            if ($request->has('solution_template')) {
                $input['solution_template'] = $request->input('solution_template');
                Log::info('📝 Solution template received');
            }

            if ($request->has('junit_tests')) {
                $input['junit_tests'] = $request->input('junit_tests');
                Log::info('🧪 JUnit tests received');
            }

            // Extract class name dari solution template atau question content
            $className = $this->extractClassNameFromContent($request);
            if ($className) {
                $input['class_name'] = $className;
                Log::info('🏷️ Class name extracted', ['class_name' => $className]);
            }

            // Create question
            $question = $this->questionRepository->create($input);

            // Handle multiple choice answers
            if ($request['is_essay'] != '1') {
                for ($i = 0; $i < 4; $i++) {
                    $ans = $request["answers_$i"];
                    $is_r = @$request["is_right_$i"];
                    Answer::create([
                        "question_id" => $question->id,
                        "answer" => $ans,
                        "is_right" => $is_r
                    ]);
                }
            }

            // Handle essay questions
            $essay_question = $request->input('essay_question');
            $key_answer = $request->input('answer_key');
            $key_answer2 = $request->input('answer_key2');
            $key_answer3 = $request->input('answer_key3');
            $key_answer4 = $request->input('answer_key4');

            foreach ($essay_question as $index => $eques) {
                $keys = $key_answer[$index] ?? '';
                $keys2 = $key_answer2[$index] ?? '';
                $keys3 = $key_answer3[$index] ?? '';
                $keys4 = $key_answer4[$index] ?? '';

                EssayQuestion::create([
                    'question_id'   => $question->id,
                    'user_id'       => Auth::id(),
                    'question'      => $eques,
                    'answer'        => $keys,
                    'answer2'       => $keys2,
                    'answer3'       => $keys3,
                    'answer4'       => $keys4
                ]);
            }

            Log::info('Question store completed', [
                'question_id' => $question->id,
                'essay_questions_count' => count($essay_question)
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Question saved successfully',
                    'question_id' => $question->id,
                    'redirect' => route('admin.questions.index')
                ]);
            }

            Flash::success('Question saved successfully.');
            return redirect(route('admin.questions.index'));
        } catch (\Exception $e) {
            Log::error('Error storing question', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error saving question: ' . $e->getMessage()
                ], 500);
            }

            Flash::error('Error saving question: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified Question.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->find($id);
        $essay_question = EssayQuestion::where('question_id', $id)->get();

        if (empty($question)) {
            Flash::error('Question not found');

            return redirect(route('admin.questions.index'));
        }

        return view('admin.questions.show')->with('question', $question)->with('essay', $essay_question);
    }

    /**
     * Show the form for editing the specified Question.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->find($id);
        $contents = Content::all()->pluck("title", "id");
        $title = "edit";
        $essay = EssayQuestion::where('question_id', $id)->get();

        if (empty($question)) {
            Flash::error('Question not found');

            return redirect(route('admin.questions.index'));
        }

        return view('admin.questions.edit')->with('question', $question)->with("contents", $contents)->with("answers", $question->answers)->with('title', $title)->with('essay', $essay);
    }

    /**
     * Update the specified Question in storage.
     *
     * @param int $id
     * @param UpdateQuestionRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            Flash::error('Question not found');

            return redirect(route('admin.questions.index'));
        }

        $input = $request->all();

        // Handle database-driven JUnit data - update JUnit data jika ada
        if ($request->has('test_cases_data')) {
            $input['test_cases_data'] = $request->input('test_cases_data');
            Log::info('📊 Test cases data updated for question', ['question_id' => $id]);
        }

        if ($request->has('solution_template')) {
            $input['solution_template'] = $request->input('solution_template');
            Log::info('📝 Solution template updated for question', ['question_id' => $id]);
        }

        if ($request->has('junit_tests')) {
            $input['junit_tests'] = $request->input('junit_tests');
            Log::info('🧪 JUnit tests updated for question', ['question_id' => $id]);
        }

        // Extract class name dari solution template atau question content
        $className = $this->extractClassNameFromContent($request);
        if ($className) {
            $input['class_name'] = $className;
            Log::info('🏷️ Class name updated for question', ['question_id' => $id, 'class_name' => $className]);
        }

        $question = $this->questionRepository->update($input, $id);

        $answers = $question->answers;
        if ($request['is_essay'] != '1') {
            if ($answers->count() == 0) {
                for ($i = 0; $i < 4; $i++) {
                    $ans = $request["answers_$i"];
                    $is_r = @$request["is_right_$i"];

                    Answer::create(["question_id" => $question->id, "answer" => $ans, "is_right" => $is_r]);
                }
            } else {
                for ($i = 0; $i < 4; $i++) {
                    $ans = $request["answers_$i"];
                    $is_r = @$request["is_right_$i"];
                    $id_ans = @$request["answer_id_$i"];
                    if (empty($id_ans)) {
                        Answer::create(["question_id" => $question->id, "answer" => $ans, "is_right" => $is_r]);
                    } else {
                        $answ = Answer::find((int)$id_ans);
                        $answ->update(["question_id" => $question->id, "answer" => $ans, "is_right" => $is_r]);
                    }
                }
            }
        } else {
            $question = $this->questionRepository->update(["is_essay" => 1], $id);
        }

        $essay_question = $request->input('essay_question');
        $key_answer = $request->input('answer_key');
        $key_answer2 = $request->input('answer_key2');
        $key_answer3 = $request->input('answer_key3');
        $key_answer4 = $request->input('answer_key4');
        $essay_id = $request->input('essay_id');

        foreach ($essay_question as $index => $eques) {
            $keys = $key_answer[$index];
            $keys2 = $key_answer2[$index];
            $keys3 = $key_answer3[$index];
            $keys4 = $key_answer4[$index];
            $essay = $essay_id[$index];

            $check_data = EssayQuestion::where('id', $essay);
            if ($check_data->count() == 0) {
                EssayQuestion::create([
                    'question_id'   => $question->id,
                    'user_id'       => Auth::id(),
                    'question'      => $eques,
                    'answer'        => $keys,
                    'answer2'        => $keys2,
                    'answer3'        => $keys3,
                    'answer4'        => $keys4
                ]);
            } else {
                $data_essay = EssayQuestion::firstwhere('id', $essay);
                $data_essay->question = $eques;
                $data_essay->answer = $keys;
                $data_essay->answer2 = $keys2;
                $data_essay->answer3 = $keys3;
                $data_essay->answer4 = $keys4;
                $data_essay->save();
            }
        }
        Flash::success('Question updated successfully.');
        Log::debug($request->all());

        return redirect(route('admin.questions.index'));
    }

    /**
     * Remove the specified Question from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            Flash::error('Question not found');

            return redirect(route('admin.questions.index'));
        }
        $essay = EssayQuestion::where('question_id', $id);
        $id_essay = $essay->pluck('id');
        $user_answer = UserAnswer::whereIn('essay_question_id', $id_essay);
        $user_score = UserScore::where('question_id', $id);

        $user_score->delete();
        $user_answer->delete();
        $essay->delete();
        $this->questionRepository->delete($id);

        Flash::success('Question deleted successfully.');

        return redirect(route('admin.questions.index'));
    }

    /**
     * Generate question with JUnit test dari LLM service
     */
    public function generateQuestionWithJunit(Request $request)
    {
        try {
            // Log semua input untuk debugging
            Log::info('🔍 Generate question request received', [
                'all_input' => $request->all(),
                'content_type' => $request->header('Content-Type'),
                'method' => $request->method()
            ]);

            $contentId = $request->input('content_id');

            if (!$contentId) {
                Log::warning('❌ Content ID missing', [
                    'available_inputs' => array_keys($request->all())
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Content ID is required'
                ], 400);
            }

            Log::info('🔄 Generating question with JUnit', [
                'content_id' => $contentId,
                'user_id' => Auth::id()
            ]);

            // Increase PHP execution time limit for this request
            set_time_limit(600); // 10 minutes

            // Call Django LLM service dengan timeout yang lebih panjang
            $response = Http::timeout(300) // 5 minutes timeout
                ->connectTimeout(60) // Connection timeout 60 seconds
                ->get(config('app.llm_generate_question'), [
                    'content_id' => $contentId
                ]);

            if (!$response->successful()) {
                Log::error('❌ LLM service error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Failed to generate question from LLM service'
                ], 500);
            }

            $data = $response->json();

            if (!$data['success']) {
                return response()->json([
                    'success' => false,
                    'error' => $data['error'] ?? 'Unknown error from LLM service'
                ], 500);
            }

            $questionData = $data['data'];

            Log::info('✅ Question generated successfully', [
                'has_junit' => !empty($questionData['junit_test_code']),
                'class_name' => $questionData['class_name'] ?? 'N/A'
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'studi_kasus' => $questionData['studi_kasus'] ?? '',
                    'tugas' => $questionData['tugas'] ?? '',
                    'code' => $questionData['code'] ?? '',
                    'solution_template' => $questionData['solution_template'] ?? $questionData['code'] ?? '',
                    'junit_test_code' => $questionData['junit_test_code'] ?? '',
                    'test_cases' => $questionData['test_cases'] ?? [],
                    'class_name' => $questionData['class_name'] ?? '',
                    'content_id' => $contentId,
                    'generation_time' => $questionData['generation_time'] ?? 0
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error generating question with JUnit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract class name from solution template or question content
     */
    private function extractClassNameFromContent(Request $request)
    {
        $solutionTemplate = $request->input('solution_template', '');
        $questionContent = $request->input('question', '');

        // Try to extract from solution template first
        if (!empty($solutionTemplate)) {
            if (preg_match('/public\s+class\s+(\w+)/', $solutionTemplate, $matches)) {
                return $matches[1];
            }
        }

        // Try to extract from question content
        if (!empty($questionContent)) {
            if (preg_match('/class\s+(\w+)/', $questionContent, $matches)) {
                return $matches[1];
            }
        }

        // Default fallback
        return 'Solution';
    }

    /**
     * Save JUnit test file (optional backup method)
     */
    private function saveJunitTestFile($className, $junitContent, $questionId)
    {
        try {
            $testDir = storage_path('app/junit_tests');
            if (!file_exists($testDir)) {
                mkdir($testDir, 0755, true);
            }

            $fileName = "{$className}Test_Q{$questionId}.java";
            $filePath = $testDir . '/' . $fileName;

            file_put_contents($filePath, $junitContent);

            Log::info('JUnit test file saved', ['file_path' => $filePath]);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('Failed to save JUnit test file', [
                'error' => $e->getMessage(),
                'class_name' => $className,
                'question_id' => $questionId
            ]);
            return null;
        }
    }
}
