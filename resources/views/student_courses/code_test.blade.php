@extends('layouts.code_test')

@section('content')
    <style>
        .codeflask__flatten {
            position: initial !important;

        }

        .codeflask__textarea {
            color: #0c0c0c;
        }

        #output {
            color: white;
            background: #444444;
            padding: 10px;
        }

        .ql-snow .ql-editor pre.ql-syntax {
            background-color: #f3f3f3;
            color: #1f1f1f;
            overflow: visible;
        }

        .spinner-logo {
            width: 50px;
            /* Adjust the size as needed */
            height: 50px;
            /* Adjust the size as needed */
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
    </style>
    <div style="margin-top: 70px">
        <div class="row">
            {{-- @if (!$is_finish) --}}
            <div class="col-md-7" style="min-height: 100vh">
                <div class="editor"></div>
            </div>
            {{-- @endif --}}

            {{-- @if ($is_finish)
        <div class="col-md-7 p-5">
          <h3>Exercise Logs ({{ $exercise_logs->count() }})</h3>
          <div>
            @foreach ($exercise_logs as $i => $exer)
              <div class="card card-sm">
                <div class="card-body">
                  @if ($exer->is_error == 1)
                    <span class="badge badge-danger mb-2"> Error</span><br />
                  @else
                    <span class="badge badge-success mb-2"> Success</span><br />
                  @endif
                    <pre>{{ $exer->message }}</pre>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif --}}

            <div class="col-md-5 p-5">
                @if ($question->hint)
                    <div class="mb-4">
                        <button type="button" id="hint" class="btn btn-outline-warning">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="m4.076 6.47l.495.07l-.495-.07Zm-.01.07l-.495-.07l.495.07Zm6.858-.07l.495-.07l-.495.07Zm.01.07l-.495.07l.495-.07ZM9.5 12.5v.5a.5.5 0 0 0 .5-.5h-.5Zm-4 0H5a.5.5 0 0 0 .5.5v-.5Zm-.745-3.347l.396-.306l-.396.306Zm5.49 0l-.396-.306l.396.306ZM6 15h3v-1H6v1ZM3.58 6.4l-.01.07l.99.14l.01-.07l-.99-.14ZM7.5 3a3.959 3.959 0 0 0-3.92 3.4l.99.14A2.959 2.959 0 0 1 7.5 4V3Zm3.92 3.4A3.959 3.959 0 0 0 7.5 3v1a2.96 2.96 0 0 1 2.93 2.54l.99-.14Zm.01.07l-.01-.07l-.99.14l.01.07l.99-.14Zm-.79 2.989c.63-.814.948-1.875.79-2.99l-.99.142a2.951 2.951 0 0 1-.59 2.236l.79.612ZM9 10.9v1.6h1v-1.599H9Zm.5 1.1h-4v1h4v-1Zm-3.5.5v-1.599H5V12.5h1ZM3.57 6.47a3.951 3.951 0 0 0 .79 2.989l.79-.612a2.951 2.951 0 0 1-.59-2.236l-.99-.142ZM6 10.9c0-.823-.438-1.523-.85-2.054l-.79.612c.383.495.64.968.64 1.442h1Zm3.85-2.054C9.437 9.378 9 10.077 9 10.9h1c0-.474.257-.947.64-1.442l-.79-.612ZM7 0v2h1V0H7ZM0 8h2V7H0v1Zm13 0h2V7h-2v1ZM3.354 3.646l-1.5-1.5l-.708.708l1.5 1.5l.708-.708Zm9 .708l1.5-1.5l-.708-.708l-1.5 1.5l.708.708Z" />
                                </svg></span>
                            hint</button>
                    </div>
                @endif
                <div class="mb-4">
                    <div class="alert alert-warning" hidden role="alert">
                        {{ $question->hint }}
                    </div>
                </div>
                <div>
                    <h3 class="card-title">Exercise</h3>
                    {!! $question->question !!}
                </div><br />
                {{-- @if (!$is_finish) --}}
                <div>
                    Run Output<br />
                    <pre id="output"></pre>
                </div>
                {{-- @else --}}
                {{-- <div>
            <span class="badge badge-info">
              Duration from {{ $user_score->started_at }} to
              {{ $user_score->ended_at }}
            </span>
            <span class="badge badge-info">
              On Timer {{ $user_score->on_timer }}
            </span>
          </div>
        @endif --}}

                <div class="form-group pt-5">
                    @if ($essay->count() > 0)
                        Code Explain <span style="color:red">*</span></br>
                    @endif



                    <input type="hidden" class="form-control" id="res" name="code_explain" required>
                    @foreach ($essay as $data)
                        <div class="form-group">
                            <label for="pertanyaan{{ $data->id }}">{{ $data->question }}</label>
                            {{-- <div id="quill{{ $data->id }}" style="height: 200px;"></div> --}}
                            @php
                                $answer = \App\Models\UserAnswer::where('user_id', Auth::id())
                                    ->where('essay_question_id', $data->id)
                                    ->first();
                            @endphp
                            <textarea type="text" name="jawaban[]" id="jawaban{{ $data->id }}" class="form-control" style="height: 200px;"
                                {{ $answer ? 'disabled' : '' }}>{{ $answer->answer ?? '' }}</textarea> <input type="hidden" name="pertanyaan_id[]"
                                value="{{ $data->id }}">
                        </div>
                    @endforeach
                    {{-- <div>
                    <div id="toolbar">
                      <!-- Add font size dropdown -->
                      <select class="ql-size">
                        <option value="small"></option>
                        <!-- Note a missing, thus falsy value, is used to reset to default -->
                        <option selected></option>
                        <option value="large"></option>
                        <option value="huge"></option>
                      </select>
                      <!-- Add a bold button -->
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-list" value="ordered"></button>
                      <button class="ql-list" value="bullet"></button>

                      <!-- Add subscript and superscript buttons -->
                      <button class="ql-script" value="sub"></button>
                      <button class="ql-script" value="super"></button>
                      <button class="ql-image"></button>
                      <button class="ql-code-block"></button>

                    </div>
                    <div id="editor">
                      @if ($explain->isNotEmpty())
                        @foreach ($explain as $explain)
                          {!! @$explain->description !!}
                        @endforeach
                      @endif
                    </div>
                  </div>
            </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Submit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Anda yakin untuk submit?<br />
                        <small>Pastikan anda sudah melakukan run code sebelum submit</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitCode()">Submit Pekerjaan</button>
                    </div>
                    <div id="loadingIndicator" style="display:none; text-align: center; padding: 10px;">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MCA1MCI+PGNpcmNsZSBjeD0iMjUiIGN5PSIyNSIgcj0iMjAiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLXdpZHRoPSI0IiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1kYXNoYXJyYXk9IjEwLjU1IDEwLjU1Ij48L2NpcmNsZT48L3N2Zz4=" alt="Loading..." class="spinner-logo">
                        <br>Please wait...
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal2" tabindex="-1" role="dialog" aria-labelledby="confirmModal2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Submit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Waktu anda sudah Habis<br />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="clearSession()">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="{{ asset('js/codeflask.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //   var quillEditors = {};

            //   @foreach ($essay as $data)
            //   var quillEditors{{ $data->id }} = new Quill('#quill{{ $data->id }}', {
            //     theme: 'snow',
            //     modules: {
            //       toolbar: [
            //         [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            //         ['bold', 'italic', 'underline', 'strike'],
            //         [{ 'script': 'sub' }, { 'script': 'super' }],
            //         [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            //         ['link', 'image'],
            //       ],
            //       syntax: true,
            //       clipboard: {
            //         matchVisual: false
            //       }
            //     }
            //   });

            //   quillEditors{{ $data->id }}.on('text-change', function() {
            //       var html = quillEditors{{ $data->id }}.root.innerHTML;
            //       document.getElementById('jawaban{{ $data->id }}').value = html;
            //     });
            //   @endforeach
            // });

            const flask = new CodeFlask('.editor', {
                language: 'js',
                lineNumbers: true,
                handleTabs: true,
            });
            window['flask'] = flask;

            function runCode() {
                console.log("running");
                //let codes = ($('#'+id).text());

                let to_compile = {
                    "code": $(".codeflask__textarea").val(),
                    "user": '{{ \Illuminate\Support\Facades\Auth::user()->email }}',
                };
                $.ajax({
                    // url: "https://fransiska.pythonanywhere.com/compiler/run",
                    url: "{{ config('app.python_api') }}",
                    type: "POST",
                    data: to_compile
                }).done(function(data) {
                    $('#output').text(`${data.output.java}\n${data.output.test_output}`);
                    $('#score').val(data.output.point || 0);

                    if (data.output.point === 0 || data.output.point === undefined) {
                        // send_err_code(data.output)
                        debugger;
                        send_exercise_code(data.output);
                    } else {
                        debugger;
                        send_exercise_code(data.output);
                        // submitCode();
                    }
                }).fail(function(data, err) {
                    // alert("fail " + JSON.stringify(data) + " " + JSON.stringify(err));
                    alert("Silahkan Isi Kode Dengan Benar!");
                });
            }

            function send_err_code(err) {
                var user_id = $("#user_id").val();
                var question_id = $("#question_id").val();
                var err = err.java + "" + err.test_output;
                var data = {
                    user_id: user_id,
                    question_id: question_id,
                    error_message: err
                }
                $.ajax({
                    url: "/api/questions/error_code_log/create",
                    type: "POST",
                    data: data
                }).done(function(data) {
                    console.log(data);
                }).fail(function(data, err) {
                    console.log(data);
                    console.log(err);
                });
            }

            function send_exercise_code(exercise) {
                var user_id = $("#user_id").val();
                var question_id = $("#question_id").val();
                var message = exercise.java + "" + exercise.test_output;

                console.log(exercise.point);
                debugger;
                if (exercise.point > 0) {
                    var is_error = 0;
                } else {
                    var is_error = 1;
                }
                console.log(is_error);
                debugger;
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
                    console.log(data);
                }).fail(function(data, exercise) {
                    console.log(data);
                    console.log(exercise);
                });
            }



            function submitCode() {
                debugger;
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
                // var essay_id = $(this).closest('.form-group').find('input[name^="pertanyaan_id"]').val();
                // var quill = "quillEditors" + essay_id;
                // var answer = quill.root.innerHTML;
                // $('#jawaban'+essay_id).val(content);
                var route =
                    "{{ route('student_course.my_course.detail.content', [':course_id', ':level_id', ':content_id']) }}";
                route = route.replace(':course_id', course_id);
                route = route.replace(':content_id', content_id);
                route = route.replace(':level_id', level_id);
                // var start_time = localStorage.getItem("start_time");
                // var end_time = moment().format("YYYY-MM-DD HH:mm:ss");

                // debugger;

                // Show the loading indicator and disable the submit button
                $("#loadingIndicator").show();
                $("#submitBtn").prop("disabled", true).text("Submitting...");

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
                        // started_at: start_time,
                        level_id: level_id,
                        // ended_at: end_time,
                        // on_timer: current_time,
                        _token: _token
                    },
                    error: function(response) {

                        debugger;
                        // Hide the loading indicator and re-enable the submit button
                        $("#loadingIndicator").show();
                        $("#submitBtn").prop("disabled", false).text("Submit Pekerjaan");
                        Swal.fire(
                            'Error!',
                            'Error, Try Again!',
                            'error'
                        );
                    },
                    success: function(response) {
                        // Hide the loading indicator and re-enable the submit button
                        $("#loadingIndicator").show();
                        $("#submitBtn").prop("disabled", false).text("Submit Pekerjaan");
                        if (response.status == 200 || response.status == 201) {
                            debugger;
                            Swal.fire(
                                'Success!',
                                'Success Submit!',
                                'success'
                            );
                            window.location.href = route;
                        } else {
                            Swal.fire(
                                'Error!',
                                'Error, Try Again!',
                                'error'
                            );
                        }
                    }
                });
                // .done(res => {
                //   clearSession()
                // }).fail(err => {
                //   clearSession()
                // })
            }
            // localStorage.clear();

            function submitCodeTO() {
                var user_id = $("#user_id").val();
                var question_id = $("#question_id").val();
                var content_id = $("#content_id").val();
                var course_id = $("#course_id").val();
                var score = $("#score").val();
                var _token = document.getElementsByName("_token")[0].value;
                var start_time = localStorage.getItem("start_time");
                var end_time = moment().format("YYYY-MM-DD HH:mm:ss");

                $.ajax({
                    url: "{{ route('code_test.submit', [$question->id]) }}",
                    method: "post",
                    data: {
                        user_id: user_id,
                        question_id: question_id,
                        content_id: content_id,
                        course_id: course_id,
                        score: score,
                        started_at: start_time,
                        ended_at: end_time,
                        on_timer: "00:00:00",
                        _token: _token
                    }
                });
            }

            function clearSession() {
                try {
                    window.localStorage.removeItem("code_session");
                    window.localStorage.removeItem("time_end");
                } finally {
                    $("#confirmModal2").modal("hide");
                    $("#confirmModal").modal("hide");
                }
            }

            $('#hint').on('click', function(e) {
                $('.alert').removeAttr('hidden');
            });
            // $('#confirmModal2').on('hidden.bs.modal', function(e) {
            //   history.back();
            // });

            // $('#confirmModal').on('hidden.bs.modal', function(e) {
            //   history.back();
            // });

            //console.log(session);

            $('#submit_code').on('click', function() {
                var isTextAreaEmpty = false;

                // Iterasi setiap textarea dengan nama 'jawaban[]'
                $('textarea[name="jawaban[]"]').each(function() {
                    if ($(this).val().trim() === '') {
                        isTextAreaEmpty = true;
                        return false; // Menghentikan iterasi jika ditemukan textarea kosong
                    }
                });

                // Memeriksa apakah ada textarea yang kosong
                if (isTextAreaEmpty) {
                    alert('Mohon jawab semua pertanyaan terlebih dahulu.');
                } else {
                    // Menjalankan modal confirmsubmit
                    $('#confirmModal').modal('show');
                    debugger;
                }




                // var textareas = $('textarea[name="jawaban[]"]');

                // // Mengecek setiap textarea
                // textareas.each(function() {
                //   var textarea = $(this);
                //   var isi = textarea.val();
                //   if (isi === '') {
                //     alert('Mohon jawab semua pertanyaan terlebih dahulu.');
                //   } else{
                //     $('#confirmModal').modal('show');
                //     debugger;
                //   }
                // });


                // if(code_explain == ""){
                //   alert("Isi penjelasan kode terlebih dahulu");
                // } else{
                //   $('#confirmModal').modal('show');
                // }
            });
            hljs.configure({ // optionally configure hljs
                languages: ['javascript', 'ruby', 'python', 'java']
            });
            $(document).ready(function() {
                var quill = new Quill('#editor', {
                    modules: {
                        syntax: true,
                        toolbar: "#toolbar"
                    },
                    theme: 'snow',
                    onChange: (value) => {
                        console.log(value)
                    }
                });

                quill.on('editor-change', function() {
                    document.getElementById("res").value = quill.root.innerHTML;
                    console.log($("#res").val());
                    console.log()
                });
            });
        </script>
    @endsection
