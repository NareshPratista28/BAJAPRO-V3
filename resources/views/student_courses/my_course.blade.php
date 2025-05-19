@extends('layouts.front')

@section('content')
    <style>
        /* Improved Styling */
        .ql-container.ql-snow {
            border: none;
        }

        .ql-editor {
            box-sizing: border-box;
            line-height: 1.6;
            height: 100%;
            outline: none;
            overflow-y: auto;
            padding: 0px;
            tab-size: 4;
            -moz-tab-size: 4;
            text-align: left;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .ql-snow .ql-editor pre.ql-syntax {
            background-color: #f8f9fa;
            color: #212529;
            border-radius: 6px;
            overflow: visible;
            padding: 15px;
        }

        .code-editor {
            padding: 20px;
            background: #f8f9fa;
            margin-top: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .code-editor-wrapper {
            height: 300px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }

        /* Content card styling */
        .content-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
        }

        .content-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 8px 8px 0 0;
        }

        /* Course navigation styling */
        .accordion-header {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .accordion-header:hover {
            background-color: #e9ecef;
        }

        .accordion-header.active {
            background-color: #007bff;
            color: white;
        }

        .list-group-item-action {
            padding: 12px 15px;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .list-group-item-action:hover {
            background-color: #f1f8ff;
            border-left: 3px solid #007bff;
        }

        .list-group-item-action.active {
            background-color: #e8f4ff;
            border-left: 3px solid #007bff;
            color: #007bff;
            font-weight: bold;
        }

        /* Badge display */
        .badge-display {
            display: flex;
            align-items: center;
        }

        .badge-display img {
            margin-left: 15px;
            transition: transform 0.3s ease;
        }

        .badge-display img:hover {
            transform: scale(1.2);
        }

        /* Progress bar */
        .progress {
            height: 10px;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #28a745;
        }

        /* Exercise card */
        .exercise-card {
            border-left: 4px solid #ffc107;
            background-color: #fffbf0;
        }

        /* Next level button */
        .next-level-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #ff7675, #d63031);
            color: white;
            font-weight: bold;
            border: none;
            transition: all 0.3s ease;
        }

        .next-level-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(214, 48, 49, 0.2);
        }

        /* Lock/unlock icons */
        .lock-icon,
        .unlock-icon {
            margin-left: 8px;
        }

        /* Scrollable content */
        .scrollable-wrapper {
            position: relative;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background-color: #f8f9fa;
            margin-top: 15px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            height: auto;
        }

        .content-description-scrollable {
            min-height: 800px;
            max-height: 1000px;
            overflow-y: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 7px;
            scrollbar-width: thin;
            scrollbar-color: #007bff #f0f0f0;
        }

        .content-description-scrollable::-webkit-scrollbar {
            width: 8px;
        }

        .content-description-scrollable::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .content-description-scrollable::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        /* Style for code blocks inside content */
        .content-description-scrollable pre {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 15px 0;
            font-family: 'Courier New', Courier, monospace;
        }

        .content-description-scrollable code {
            background-color: #f0f0f0;
            color: #e74c3c;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: 'Courier New', Courier, monospace;
        }

        #scrollable-element {
            scrollbar-width: thin;
            scrollbar-color: #007bff #f0f0f0;
            max-height: 500px;
            padding: 10px;
        }

        #scrollable-element::-webkit-scrollbar {
            width: 8px;
        }

        #scrollable-element::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        #scrollable-element::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }
    </style>
    <section class="section mt-4" id="interactive">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Video Player -->
                    <div class="content-card">
                        <div class="video-container">
                            <iframe src='{{ $content->url_video }}' title="Video Player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    @if ($content != null)
                        <!-- Content Description -->
                        <div class="content-card">
                            <div class="card-body">
                                <h2 class="section-title mb-3">{{ $content->title }}</h2>
                                <div class="mb-3">
                                    <span class="badge badge-info p-2">
                                        <i class="fas fa-book mr-1"></i> Lesson Material
                                    </span>
                                    <small class="text-muted ml-2">Scroll through the entire content to unlock the
                                        exercise</small>
                                </div>
                                <div class="scrollable-wrapper">
                                    <div id="scrollable-element" class="content-description-scrollable">
                                        <div class="section-lead">
                                            <div>{!! $content->description !!}</div>
                                        </div>
                                        <input type="hidden" name="content_id" value="{{ $content->id }}">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Section -->
                        @if (sizeof($questions) != 0 && empty($score))
                            <div class="content-card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title d-flex align-items-center">
                                        <i class="fas fa-question-circle text-primary mr-2"></i>
                                        Assessment Questions
                                    </h5>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        Complete these questions to progress in the course.
                                    </div>
                                    <div class="navbar-divider mb-3"></div>
                                    <div>
                                        @foreach ($questions as $index => $question)
                                            @if ($question->is_essay == '0')
                                                <div class="p-3 mb-3 bg-light rounded">
                                                    <h6 class="font-weight-bold">{{ $index + 1 }}.
                                                        {!! $question->question !!}</h6>
                                                    <div class="ml-2 mt-3">
                                                        <p class="text-muted mb-2">Select your answer:</p>
                                                        @foreach ($question->answers as $answer)
                                                            <div class="custom-control custom-radio my-2">
                                                                <input type="radio" id="answer_{{ $answer->id }}"
                                                                    name="answer_{{ $question->id }}"
                                                                    class="custom-control-input" value="{{ $answer->id }}"
                                                                    v-on:change="changeAnswer({{ $index }},{{ $answer->id }})">
                                                                <label class="custom-control-label"
                                                                    for="answer_{{ $answer->id }}">
                                                                    {{ $answer->answer }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <button class="btn btn-primary btn-lg mt-3 px-4"
                                            v-on:click="checkAnswer({{ \Illuminate\Support\Facades\Auth::id() }}, {{ $content->id }})">
                                            <i class="fas fa-check-circle mr-2"></i> Submit Answers
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Code Exercise Section -->
                        @if (sizeof($code_tests) != 0)
                            @foreach ($code_tests as $index => $question)
                                <div class="content-card mt-4 exercise-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-code text-warning mr-2" style="font-size: 24px;"></i>
                                            <h3 class="card-title mb-0">Coding Exercise</h3>
                                        </div>
                                        <div class="mb-4">
                                            {!! $question->question !!}
                                        </div>

                                        <div class="mt-4">
                                            @if ($check_read == 0 && $content->id > 1)
                                                <button id="button-test" class="btn btn-primary btn-lg disabled">
                                                    <i class="fas fa-lock mr-2"></i> Complete the lesson to unlock
                                                </button>
                                                <small class="d-block text-muted mt-2">
                                                    <i class="fas fa-info-circle"></i>
                                                    Scroll through all the material to unlock this exercise
                                                </small>
                                            @else
                                                <a href="{{ route('code_test', ['question_id' => $question->id, 'course_id' => $course->id, 'content_id' => $content->id, 'level_id' => $level->id]) }}"
                                                    id="button-test" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-code mr-2"></i> Start Coding Exercise
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Score Display -->
                        @if (!empty($score))
                            <div class="alert alert-success mt-4 p-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-trophy mr-3" style="font-size: 2rem;"></i>
                                    <div>
                                        <h5 class="font-weight-bold mb-1">Congratulations!</h5>
                                        <p class="mb-0">Your score is: <span
                                                class="font-weight-bold">{{ @$score->score }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Score Card -->
                    <div class="content-card">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <i class="fa fa-medal text-primary mr-2"></i>
                                Your Progress
                            </h5>

                            <div class="badge-display mb-4">
                                <div>
                                    <h6 class="font-weight-bold mb-1">Total Score</h6>
                                    <h3 class="text-primary mb-0">{{ $final_score }}</h3>
                                </div>
                                <img src="/image_upload/{{ $current_badge->file }}" width="60px" class="ml-auto"
                                    title="{{ $current_badge->name }}">
                            </div>

                            <div class="alert alert-info d-flex align-items-center p-3 mb-4">
                                <i class="fas fa-award mr-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <p class="mb-0">Your Badge is <b>{{ $current_badge->name }}</b></p>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <b>Code Test Progress</b>
                                    <span class="badge badge-primary">{{ $percentage }}%</span>
                                </div>
                                <div class="progress mb-1">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small
                                    class="text-muted">{{ $percentage < 50 ? 'Keep going!' : ($percentage < 100 ? 'Almost there!' : 'Completed!') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content Navigation -->
                    <div class="content-card mt-4">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <i class="fas fa-book-open mr-2"></i>
                                Course Content
                            </h5>

                            <div class="accordion" id="accordionExample">
                                @foreach ($level->lessons as $index => $lesson)
                                    <div class="accordion-item mb-2">
                                        <div class="accordion-header {{ $active_lesson->id == $lesson->id ? 'active' : '' }}"
                                            data-toggle="collapse" data-target="#item{{ $index }}"
                                            aria-expanded="{{ $active_lesson->id == $lesson->id ? 'true' : 'false' }}"
                                            aria-controls="collapseOne">
                                            <i
                                                class="fas {{ $active_lesson->id == $lesson->id ? 'fa-folder-open' : 'fa-folder' }} mr-2"></i>
                                            {{ $lesson->title }}
                                        </div>
                                        <div id="item{{ $index }}"
                                            class="accordion-collapse collapse {{ $active_lesson->id == $lesson->id ? 'show' : '' }}"
                                            aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <div class="list-group row list-group-flush">
                                                    @foreach ($lesson->contents as $key => $content)
                                                        @php

                                                            if ($index == 0) {
                                                                if ($key > 0) {
                                                                    $content_id = $lesson->contents[$key - 1]->id;
                                                                    $question = \App\Models\Question::where(
                                                                        'content_id',
                                                                        $content_id,
                                                                    )
                                                                        ->pluck('id')
                                                                        ->toArray();
                                                                    $check = \App\Models\UserScore::where(
                                                                        'user_id',
                                                                        Auth::user()->id,
                                                                    )
                                                                        ->where('content_id', $content_id)
                                                                        ->count();
                                                                    if ($check > 0) {
                                                                        $is_open = 1;
                                                                    } else {
                                                                        $is_open = 0;
                                                                    }
                                                                } else {
                                                                    $is_open = 1;
                                                                }
                                                            } else {
                                                                if ($key == 0) {
                                                                    $prev_lesson = $level->lessons[$index - 1]->id;
                                                                    $content_id = \App\Models\Content::where(
                                                                        'lesson_id',
                                                                        $prev_lesson,
                                                                    )
                                                                        ->pluck('id')
                                                                        ->last();
                                                                    $question = \App\Models\Question::where(
                                                                        'content_id',
                                                                        $content_id,
                                                                    )
                                                                        ->pluck('id')
                                                                        ->toArray();
                                                                    $check = \App\Models\UserScore::where(
                                                                        'user_id',
                                                                        Auth::user()->id,
                                                                    )
                                                                        ->where('content_id', $content_id)
                                                                        ->count();
                                                                    if ($check > 0) {
                                                                        $is_open = 1;
                                                                    } else {
                                                                        $is_open = 0;
                                                                    }
                                                                } elseif ($key > 0) {
                                                                    $content_id = $lesson->contents[$key - 1]->id;
                                                                    $question = \App\Models\Question::where(
                                                                        'content_id',
                                                                        $content_id,
                                                                    )
                                                                        ->pluck('id')
                                                                        ->toArray();
                                                                    $check = \App\Models\UserScore::where(
                                                                        'user_id',
                                                                        Auth::user()->id,
                                                                    )
                                                                        ->where('content_id', $content_id)
                                                                        ->count();
                                                                    if ($check > 0) {
                                                                        $is_open = 1;
                                                                    } else {
                                                                        $is_open = 0;
                                                                    }
                                                                }
                                                            }

                                                        @endphp

                                                        @if ($is_open == 1)
                                                            <a href="{{ route('student_course.my_course.detail.content', [$course->id, $level->id, $content->id]) }}"
                                                                class="list-group-item list-group-item-action {{ $content->id == $active_content->id ? 'active' : '' }}">
                                                                <i
                                                                    class="fas {{ $content->id == $active_content->id ? 'fa-play-circle' : 'fa-circle' }} mr-2"></i>
                                                                {{ $content->title }}

                                                                <span class="float-right unlock-icon">
                                                                    <i class="fas fa-unlock-alt text-success"></i>
                                                                </span>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                class="list-group-item list-group-item-action disabled">
                                                                <i class="fas fa-circle mr-2"></i>
                                                                {{ $content->title }}

                                                                <span class="float-right lock-icon">
                                                                    <i class="fas fa-lock text-muted"></i>
                                                                </span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Next Level Button -->
                    @if ($is_last == 1)
                        <div class="content-card mt-4">
                            <a style="height:60px" class="btn next-level-btn btn-lg btn-block"
                                href="{{ route('student_course.level', [$course->id]) }}">
                                <span>Next Level</span>
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Explanation Modal -->
    <div class="modal fade" id="modal-explain" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="exampleModalLongTitle">
                        <i class="fas fa-comment-dots mr-2"></i> Explain Your Understanding
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-explain" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Share your understanding of this level's concepts to demonstrate your learning.
                        </div>

                        <div class="form-group">
                            <label>Your Explanation <span class="text-danger">*</span></label>
                            <textarea required class="form-control" name="explanation" style="height:200px"
                                placeholder="Explain the key concepts you learned in this level..."></textarea>
                        </div>
                        <input type="hidden" value="{{ $course->id }}" id="course_id" name="course_id">
                        <input type="hidden" value="{{ $level->id }}" id="level_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submit-explain" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Explanation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/prism.js') }}"></script>
    <script src="{{ asset('js/codeflask.min.js') }}"></script>

    <script>
        var scrollElement = document.getElementById('scrollable-element');
        var hasScrolledToBottom = false;

        // Use a more flexible approach for height
        function adjustScrollableHeight() {
            var windowHeight = window.innerHeight;
            var elementOffset = scrollElement.getBoundingClientRect().top;
            var availableHeight = windowHeight - elementOffset - 100; // 100px buffer from bottom of window

            // Set a reasonable min and max height
            var finalHeight = Math.min(Math.max(availableHeight, 200), 400);
            scrollElement.style.maxHeight = finalHeight + "px";
        }

        // Call once on page load
        adjustScrollableHeight();

        // Also adjust on window resize
        window.addEventListener('resize', adjustScrollableHeight);

        scrollElement.addEventListener('scroll', function() {
            // Check if scrolled to bottom (with a small buffer)
            if (!hasScrolledToBottom &&
                (scrollElement.scrollTop + scrollElement.clientHeight >= scrollElement.scrollHeight - 30)) {

                hasScrolledToBottom = true;
                scoreRead();

                // Provide visual feedback that content has been completely read
                scrollElement.parentNode.classList.add('content-read');

                // Enable the button if it exists
                if (document.getElementById('button-test')) {
                    document.getElementById('button-test').classList.remove('disabled');
                    document.getElementById('button-test').innerHTML =
                        '<i class="fas fa-code mr-2"></i> Start Coding Exercise';

                    // Show a visual indicator that exercise is unlocked
                    const notification = document.createElement('div');
                    notification.className = 'content-unlocked-notification';
                    notification.innerHTML = '<i class="fas fa-unlock-alt"></i> Exercise unlocked!';
                    document.querySelector('.content-card').appendChild(notification);

                    // Remove the notification after 5 seconds
                    setTimeout(function() {
                        notification.classList.add('fade-out');
                        setTimeout(function() {
                            notification.remove();
                        }, 500);
                    }, 5000);
                }
            }
        });

        function scoreRead() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var content_id = $('input[name="content_id"]').val();

            $.ajax({
                url: "{{ route('student_course.read.score') }}", // Ganti '/post-nilai' dengan URL rute yang sesuai di Laravel
                type: 'POST',
                data: {
                    content_id: content_id
                },
                success: function(response) {
                    // Tanggapan sukses dari server, lakukan tindakan yang sesuai
                    console.log(response);

                },
                error: function(xhr) {
                    // Penanganan kesalahan saat melakukan permintaan Ajax
                    console.log(xhr.responseText);
                }
            });

        }
    </script>

    <script>
        const flask = new CodeFlask('.editor', {
            language: 'js',
            lineNumbers: true,
            handleTabs: true,
        });

        flask.addLanguage('java', Prism.languages['java']);


        function runCode(id) {
            console.log("running");
            //let codes = ($('#'+id).text());
            let to_compile = {
                "code": flask.getCode(),
                "user": '{{ \Illuminate\Support\Facades\Auth::user()->email }}',
            };
            $.ajax({
                // url: "https://fransiska.pythonanywhere.com/compiler/run",
                url: "{{ config('app.python_api') }}",
                type: "POST",
                data: to_compile
            }).done(function(data) {
                $('#output_' + id).text(`${data.output.java}\n${data.output.test_output}`);
            }).fail(function(data, err) {
                alert("fail " + JSON.stringify(data) + " " + JSON.stringify(err));
            });
        }
    </script>

    <script>
        $('#create-explain').submit(function(e) {
            e.preventDefault();
            var level = $('#level_id').val();
            var course = $('#course_id').val();
            var url = "{{ route('student_course.explain', ':level') }}"
            url = url.replace(':level', level);

            var redirect = "{{ route('student_course.level', ':course_id') }}";
            redirect = redirect.replace(':course_id', course);

            console.log(level);
            debugger;
            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                error: function(err) {
                    $("#submit-explain").show();
                    Swal.fire(
                        'Gagal',
                        err.responseJSON.error,
                        'error'
                    );
                },
                success: function(response) {
                    if (response.status == 200 || response.status == 201) {
                        Swal.fire(
                            'Success!',
                            'Your answer submit successfully, go to the next level!',
                            'success'
                        );
                        window.location.href = redirect;
                    } else {
                        Swal.fire(
                            'Error!',
                            'Error input data!',
                            'error'
                        );
                    }
                },
            })
        });
    </script>
@endsection
