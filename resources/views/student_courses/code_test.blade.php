<!-- filepath: c:\Projects\Skripsi\BAJAPRO-V3\resources\views\student_courses\code_test.blade.php -->
@extends('layouts.code_test')

@section('content')
    <style>
        /* Base Styles */
        :root {
            --primary-color: #4a6cf7;
            --success-color: #38c172;
            --warning-color: #f7b731;
            --danger-color: #fc5c65;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --border-color: #e9ecef;
            --text-color: #333;
            --code-bg: #282c34;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-color);
            background-color: #f5f7fb;
        }

        /* Code Editor */
        .codeflask__flatten {
            position: initial !important;
        }

        .code-editor-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: calc(100vh - 100px);
            display: flex;
            flex-direction: column;
        }

        .editor-header {
            background: var(--code-bg);
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .editor-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .editor-header h4 i {
            margin-right: 8px;
            font-size: 18px;
        }

        .editor-actions {
            display: flex;
            gap: 8px;
        }

        .editor {
            flex: 1;
            background: white;
            overflow: hidden;
        }

        .codeflask__textarea {
            color: #0c0c0c;
            font-family: 'Fira Code', monospace;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Output and Instructions */
        .code-sidebar {
            height: calc(100vh - 100px);
            overflow-y: auto;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .exercise-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .exercise-card .card-header {
            padding: 15px;
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
        }

        .exercise-card .card-header i {
            margin-right: 8px;
            font-size: 18px;
        }

        .exercise-card .card-body {
            padding: 20px;
        }

        .hint-container {
            margin-bottom: 20px;
        }

        .hint-button {
            background-color: var(--warning-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hint-button:hover {
            background-color: #e5a100;
            transform: translateY(-2px);
        }

        .hint-button i,
        .hint-button svg {
            margin-right: 6px;
        }

        .hint-content {
            margin-top: 10px;
            padding: 15px;
            background-color: #fff9e6;
            border-left: 4px solid var(--warning-color);
            border-radius: 4px;
        }

        #output {
            background: var(--dark-color);
            color: white;
            padding: 15px;
            border-radius: 6px;
            font-family: 'Fira Code', monospace;
            font-size: 14px;
            white-space: pre-wrap;
            overflow-x: auto;
            min-height: 100px;
            max-height: 300px;
            overflow-y: auto;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: var(--dark-color);
        }

        textarea.form-control {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            resize: none;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        textarea.form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.15);
            outline: none;
        }

        /* Modals */
        .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
            padding: 15px 20px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        /* Loading Spinner */
        .spinner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .spinner-logo {
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Output Status Indicators */
        .output-success {
            border-left: 4px solid var(--success-color);
        }

        .output-error {
            border-left: 4px solid var(--danger-color);
        }

        .output-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .output-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .output-title i {
            margin-right: 6px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.success {
            background-color: rgba(56, 193, 114, 0.1);
            color: var(--success-color);
        }

        .status-badge.error {
            background-color: rgba(252, 92, 101, 0.1);
            color: var(--danger-color);
        }

        .status-badge.running {
            background-color: rgba(74, 108, 247, 0.1);
            color: var(--primary-color);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {

            .code-editor-container,
            .code-sidebar {
                height: auto;
                margin-bottom: 20px;
            }
        }

        /* Syntax Highlighting */
        .ql-snow .ql-editor pre.ql-syntax {
            background-color: #f3f3f3;
            color: #1f1f1f;
            overflow: visible;
            border-radius: 4px;
        }
    </style>

    <div style="margin-top: 70px">
        <div class="container-fluid px-4">
            <div class="row">
                <!-- Code Editor Column -->

                <div class="editor"></div>

                <!-- Instructions & Output Column -->
                <div class="col-lg-5">
                    <div class="code-sidebar">
                        <!-- Exercise Instructions -->
                        <div class="exercise-card">
                            <div class="card-header">
                                <i class="fas fa-tasks"></i> Exercise
                            </div>
                            <div class="card-body">
                                @if ($question->hint)
                                    <div class="hint-container">
                                        <button type="button" id="hint" class="hint-button btn-block">
                                            <i class="fas fa-lightbulb"></i> Show Hint
                                        </button>
                                        <div class="hint-content alert alert-warning mt-2" hidden>
                                            {{ $question->hint }}
                                        </div>
                                    </div>
                                @endif

                                <div class="exercise-instructions">
                                    {!! $question->question !!}
                                </div>
                            </div>
                        </div>

                        <!-- Run Output -->
                        <div class="exercise-card">
                            <div class="card-header">
                                <i class="fas fa-terminal"></i> Output
                            </div>
                            <div class="card-body">
                                <div class="output-header">
                                    <h6 class="output-title">
                                        <i class="fas fa-code"></i> Run Result
                                    </h6>
                                    <span class="status-badge" id="output-status"></span>
                                </div>
                                <pre id="output">// Your code output will appear here after running...</pre>
                            </div>
                        </div>

                        <!-- Code Explanation -->
                        @if ($essay->count() > 0)
                            <div class="exercise-card">
                                <div class="card-header">
                                    <i class="fas fa-file-alt"></i> Explanation
                                </div>
                                <div class="card-body">
                                    <input type="hidden" class="form-control" id="res" name="code_explain" required>

                                    @foreach ($essay as $data)
                                        <div class="form-group">
                                            <label for="pertanyaan{{ $data->id }}">{{ $data->question }}</label>
                                            @php
                                                $answer = \App\Models\UserAnswer::where('user_id', Auth::id())
                                                    ->where('essay_question_id', $data->id)
                                                    ->first();
                                            @endphp
                                            <textarea name="jawaban[]" id="jawaban{{ $data->id }}" class="form-control"
                                                placeholder="Explain your solution here..." style="height: 150px;" {{ $answer ? 'disabled' : '' }}>{{ $answer->answer ?? '' }}</textarea>
                                            <input type="hidden" name="pertanyaan_id[]" value="{{ $data->id }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Exercise
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Are you sure you want to submit your exercise?
                    </div>
                    <p class="text-muted"><small>Make sure you've run your code before submitting.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="button" id="submitBtn" class="btn btn-primary" onclick="submitCode()">
                        <i class="fas fa-check mr-1"></i> Submit Exercise
                    </button>
                </div>
                <div id="loadingIndicator" class="spinner-container" style="display:none;">
                    <img src="{{ asset('img/logo-single.png') }}" alt="Loading..." class="spinner-logo">
                    <p class="mt-2">Processing your submission...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeout Modal -->
    {{-- <div class="modal fade" id="confirmModal2" tabindex="-1" role="dialog" aria-labelledby="confirmModal2"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-clock mr-2"></i> Time's Up
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Your time has expired
                    </div>
                    <p>Please submit your solution or return to the course page.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="clearSession()">
                        <i class="fas fa-check mr-1"></i> OK
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script src="{{ asset('js/codeflask.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        // Editor initialization
        const flask = new CodeFlask('.editor', {
            language: 'js',
            lineNumbers: true,
            handleTabs: true,
        });
        window['flask'] = flask;

        // Add custom styles to make the editor better
        document.head.insertAdjacentHTML("beforeend", `
        <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    `);

        // Run code function with UI enhancements
        function runCode() {
            // Show running indicator
            $('#output-status').text('Running...').removeClass('success error').addClass('running');
            $('#output').text('Processing your code...');

            let to_compile = {
                "code": $(".codeflask__textarea").val(),
                "user": '{{ \Illuminate\Support\Facades\Auth::user()->email }}',
            };

            $.ajax({
                url: "{{ config('app.python_api') }}",
                type: "POST",
                data: to_compile
            }).done(function(data) {
                // Update output with formatted result
                $('#output').text(`${data.output.java}\n${data.output.test_output}`);
                $('#score').val(data.output.point || 0);

                // Update status badge
                if (data.output.point === 0 || data.output.point === undefined) {
                    $('#output-status').text('Failed').removeClass('running').addClass('error');
                    $('#output').addClass('output-error').removeClass('output-success');
                    send_exercise_code(data.output);
                } else {
                    $('#output-status').text('Success').removeClass('running').addClass('success');
                    $('#output').addClass('output-success').removeClass('output-error');
                    send_exercise_code(data.output);
                }
            }).fail(function(data, err) {
                $('#output-status').text('Error').removeClass('running').addClass('error');
                $('#output').text("Error: Please check your code and try again.");
                alert("Please write valid code before running!");
            });
        }

        function send_exercise_code(exercise) {
            var user_id = $("#user_id").val();
            var question_id = $("#question_id").val();
            var message = exercise.java + "" + exercise.test_output;

            if (exercise.point > 0) {
                var is_error = 0;
            } else {
                var is_error = 1;
            }

            var data = {
                user_id: user_id,
                question_id: question_id,
                message_content: message,
                is_error: is_error
            }

            $.ajax({
                url: "/api/questions/exercise_code_log/create",
                type: "POST",
                data: data
            }).done(function(data) {
                console.log("Exercise code logged");
            }).fail(function(data, exercise) {
                console.error("Failed to log exercise code");
            });
        }

        function submitCode() {
            var user_id = $("#user_id").val();
            var question_id = $("#question_id").val();
            var content_id = $("#content_id").val();
            var course_id = $("#course_id").val();
            var level_id = $("#level_id").val();
            var score = $("#score").val();
            var code_explain = $('input[name="code_explain"]').val();
            var _token = document.getElementsByName("_token")[0].value;
            var inputQuestion = [];
            var inputAnswer = [];

            $('input[name="pertanyaan_id[]"]').each(function() {
                inputQuestion.push($(this).val());
            });

            $('textarea[name="jawaban[]"]').each(function() {
                inputAnswer.push($(this).val());
            });

            var route =
                "{{ route('student_course.my_course.detail.content', [':course_id', ':level_id', ':content_id']) }}";
            route = route.replace(':course_id', course_id);
            route = route.replace(':content_id', content_id);
            route = route.replace(':level_id', level_id);

            // Show loading state
            $("#loadingIndicator").show();
            $(".modal-footer").hide();
            $("#submitBtn").prop("disabled", true);

            $.ajax({
                url: "{{ route('code_test.submit', [$question->id]) }}",
                method: "post",
                data: {
                    user_id: user_id,
                    question_id: question_id,
                    content_id: content_id,
                    course_id: course_id,
                    score: score,
                    code_explain: code_explain,
                    answer: inputAnswer,
                    essay_id: inputQuestion,
                    level_id: level_id,
                    _token: _token
                },
                error: function(response) {
                    // Hide loading state
                    $("#loadingIndicator").hide();
                    $(".modal-footer").show();
                    $("#submitBtn").prop("disabled", false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: 'There was an error submitting your solution. Please try again.',
                        confirmButtonColor: '#fc5c65'
                    });
                },
                success: function(response) {
                    // Hide loading state
                    $("#loadingIndicator").hide();
                    $(".modal-footer").show();
                    $("#submitBtn").prop("disabled", false);

                    if (response.status == 200 || response.status == 201) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Submitted Successfully!',
                            text: 'Your solution has been submitted successfully.',
                            confirmButtonColor: '#38c172'
                        }).then(() => {
                            window.location.href = route;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: 'There was an error submitting your solution. Please try again.',
                            confirmButtonColor: '#fc5c65'
                        });
                    }
                }
            });
        }

        // Session cleanup function
        function clearSession() {
            try {
                window.localStorage.removeItem("code_session");
                window.localStorage.removeItem("time_end");
            } finally {
                $("#confirmModal2").modal("hide");
                $("#confirmModal").modal("hide");
            }
        }

        // Hint toggle
        $('#hint').on('click', function(e) {
            const hintContent = $('.hint-content');
            if (hintContent.is(':hidden')) {
                hintContent.slideDown(200);
                $(this).html('<i class="fas fa-eye-slash"></i> Hide Hint');
            } else {
                hintContent.slideUp(200);
                $(this).html('<i class="fas fa-lightbulb"></i> Show Hint');
            }
        });

        // Submit code validation
        $('#submit_code').on('click', function() {
            var isTextAreaEmpty = false;

            $('textarea[name="jawaban[]"]').each(function() {
                if ($(this).val().trim() === '') {
                    isTextAreaEmpty = true;
                    $(this).addClass('is-invalid');
                    return false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (isTextAreaEmpty) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Explanations',
                    text: 'Please answer all questions before submitting your solution.',
                    confirmButtonColor: '#f7b731'
                });
            } else {
                $('#confirmModal').modal('show');
            }
        });
    </script>
@endsection
