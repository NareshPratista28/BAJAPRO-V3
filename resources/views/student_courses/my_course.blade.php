@extends('layouts.front')

@section('content')
  <style>
    .ql-container.ql-snow {
      border: none;
    }

    .ql-editor {
      box-sizing: border-box;
      line-height: 1.42;
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
      background-color: #f3f3f3;
      color: #1f1f1f;
      overflow: visible;
    }


    .code-editor {
      padding: 20px;
      background: #f3f3f3;
      margin-top: 10px;
    }

    .code-editor-wrapper {
      height: 300px;
    }

    .list-ac {
      background: #c4c4c4;
      color: #0c0c0c;
    }
  </style>
  <section class="section mt-5" id="interactive">
    <div class="row">
      <div class="col-md-8">
<!-- {{ $content->url_video }} -->

        <div>
          <div class="card" style="height: 450px">
            <iframe width="auto" height="450px" src='{{ $content->url_video }}'
              title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;
              clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
          </div>
          @if ($content != null)
            <div class="card mt-5">
              <div class="card-body">
                <h2 class="section-title">{{ $content->title }}</h2>
                <div id="scrollable-element" style="overflow-y: scroll;">
                  <div class="section-lead">
                    <div>{!! $content->description !!}</div>
  
                    <br /><br />
                  </div>
                  <input type="hidden" name="content_id" value="{{$content->id}}">
                </div>
              </div>
            </div>
            <!-- Your content goes here -->

            @if (sizeof($questions) != 0 && empty($score))
              <div class="card mt-5">
                {{ $score }}
                <div class="card-body">
                  <h6 class="card-title">Questions</h6>
                  <div class="navbar-divider"></div>
                  <div>
                    @foreach ($questions as $index => $question)
                      @if ($question->is_essay == '0')
                        <div>{{ $index + 1 }}.{!! $question->question !!}<br />
                          <div class="ml-2">
                            <small>Your answer</small>
                            <br />
                            @foreach ($question->answers as $answer)
                              <div>
                                <input type="radio" name="answer_{{ $question->id }}" value="{{ $answer->id }}"
                                  v-on:change="changeAnswer({{ $index }},{{ $answer->id }})">
                                {{ $answer->answer }}
                              </div>
                            @endforeach
                          </div>
                          <br />

                        </div><br />
                      @endif
                    @endforeach

                    {{--<a href="api/questions/check_answer/" class="btn btn-primary" >
                      Finish
                    </a>--}}

                    <button class="btn btn-primary"
                      v-on:click="checkAnswer({{ \Illuminate\Support\Facades\Auth::id() }}, {{ $content->id }})">
                      Finish
                    </button>
                  </div>

                </div>
              </div>
            @endif


            @if (sizeof($code_tests) != 0)
              @foreach ($code_tests as $index => $question)
                <div class="card">
                  <div class="card-body">
                    <div>
                      <h3 class="card-title">Exercise</h3>
                    </div>
                      <div>
                        {!! $question->question !!}
                        {{--@if (in_array($question->id, $finish_code_tests))
                          <a href="{{ route('code_test', ['question_id' => $question->id, 'course_id' => $course->id, 'content_id' => $content->id, 'level_id' => $level->id]) }}"
                            class="btn btn-primary">See Result</a>
                        @else --}}
                       

                        @if($check_read == 0 && $content->id > 1)
                          <a href="{{ route('code_test', ['question_id' => $question->id, 'course_id' => $course->id, 'content_id' => $content->id, 'level_id' => $level->id]) }}"
                            id="button-test" class="btn btn-primary disabled" >Let's Test</a>
                        @else
                          <a href="{{ route('code_test', ['question_id' => $question->id, 'course_id' => $course->id, 'content_id' => $content->id, 'level_id' => $level->id]) }}"
                            id="button-test" class="btn btn-primary" >Let's Test</a>
                        @endif
                        
                            {{--@endif--}}

                        {{-- <br><hr /> --}}
                        {{-- <b>write your answer</b> --}}
                        {{-- <button class="btn btn-primary" onclick="runCode('{{ 'sc'.$index }}')">Run</button> --}}
                        {{-- <div class="code-editor-wrapper"> --}}
                        {{-- <div id="sc{{$index}}" class="editor"></div> --}}
                        {{-- <br clear="all" /> --}}
                        {{-- </div> --}}

                        {{-- <br clear="all" /> --}}

                        {{-- <br /><br /> --}}
                        {{-- Output<br /> --}}
                        {{-- <pre class="code-editor" id="output_sc{{$index}}"></pre> --}}
                      </div>
                    </div>
                    
                  </div>
                @endforeach
            @endif

            @if (!empty($score))
              <div class="alert alert-success">
                <h5>Your score is: {{ @$score->score }}</h5>
              </div>
            @endif
          @endif
        </div>

      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa fa-medal text-primary"></i> Total Score: {{ $final_score }}
            </h5>
            <div class="alert alert-info">
              Your Badge is <b>{{ $current_badge->name }}</b>
              <img src="/image_upload/{{ $current_badge->file }}" width="50px">
            </div><br />

            <div>
              <b>Your Code Test Progress ({{ $percentage }}%)</b>
              <div class="progress mt-2">
                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;"
                  aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $percentage }}%</div>
              </div>
            </div>

          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              Lesson Content
            </h5>
            <div class="accordion" id="accordionExample">
              @foreach ($level->lessons as $index => $lesson)
                <div class="accordion-item">
                  <div class="accordion-header" data-toggle="collapse" data-target="#item{{ $index }}"
                    aria-expanded="{{ $active_lesson->id == $lesson->id ? 'true' : 'false' }}"
                    aria-controls="collapseOne">
                    
                    {{ $lesson->title }}
                  </div>
                  <div id="item{{ $index }}"
                    class="accordion-collapse collapse {{ $active_lesson->id == $lesson->id ? 'show' : '' }}"
                    aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="list-group row list-group-flush">
                        @foreach ($lesson->contents as $key => $content)
                          @php
                          
                          if($index == 0){
                            
                            if($key > 0){

                              $content_id = $lesson->contents[$key - 1]->id;
                              $question = \App\Models\Question::where('content_id', $content_id)->pluck('id')->toArray();
                              $check = \App\Models\UserScore::where('user_id', Auth::user()->id)->where('content_id', $content_id)->count();
                              if($check >0 ){
                                $is_open = 1;
                              } else{
                                $is_open = 0;
                              }
                            } else{
                              $is_open = 1;
                            }
                            
                          } else{
                            if($key == 0){

                              $prev_lesson = $level->lessons[$index -1]->id;
                              $content_id = \App\Models\Content::where('lesson_id', $prev_lesson)->pluck('id')->last();
                              $question = \App\Models\Question::where('content_id', $content_id)->pluck('id')->toArray();
                              $check = \App\Models\UserScore::where('user_id', Auth::user()->id)->where('content_id', $content_id)->count();
                              if($check >0 ){
                                $is_open = 1;
                              } else{
                                $is_open = 0;
                              }
                            } else if($key > 0){
                              $content_id = $lesson->contents[$key - 1]->id;
                              $question = \App\Models\Question::where('content_id', $content_id)->pluck('id')->toArray();
                              $check = \App\Models\UserScore::where('user_id', Auth::user()->id)->where('content_id', $content_id)->count();
                              if($check >0 ){
                                $is_open = 1;
                              } else{
                                $is_open = 0;
                              }
                            }
                          }
                          @endphp

                          @if($is_open == 1)
                            <a href="{{ route('student_course.my_course.detail.content', [$course->id, $level->id, $content->id]) }}"
                              type="button"
                              class="list-group-item list-group-item-action {{ $content->id == $active_content->id ? 'active' : '' }}">
                              {{ $content->title }}
                              
                              <span class="float-right">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h9V6q0-1.25-.875-2.125T12 3q-1.025 0-1.813.613T9.126 5.15q-.125.375-.388.613T8.126 6q-.5 0-.8-.338t-.2-.762Q7.5 3.225 8.85 2.112T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17Z"/></svg>
                              </span>
                            </a>
                          @else
                            <a href="javascript:void(0)"
                              type="button"
                              class="list-group-item list-group-item-action {{ $content->id == $active_content->id ? 'active' : '' }}">
                              {{ $content->title }}
                              
                              <span class="float-right">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h1V6q0-2.075 1.463-3.538T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17ZM9 8h6V6q0-1.25-.875-2.125T12 3q-1.25 0-2.125.875T9 6v2Z"/></svg>
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
        
        <!-- Button trigger modal -->
        {{--@if($is_last  == 1 && $check_explain == 0)
        <div class="card d-flex flex-column">
          <button type="button" style="height:50px" class="btn btn-danger mt-auto" data-toggle="modal" data-target="#modal-explain">
            Next Level 
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m12 20l-1.425-1.4l5.6-5.6H4v-2h12.175l-5.6-5.6L12 4l8 8Z"/></svg>
            </span>
          </button>
        </div>--}}
        @if($is_last == 1)
          <div class="card d-flex flex-column">
            <a type="button" style="height:50px" class="btn btn-danger mt-auto" href="{{route('student_course.level',[$course->id]) }}">
              Next Level 
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m12 20l-1.425-1.4l5.6-5.6H4v-2h12.175l-5.6-5.6L12 4l8 8Z"/></svg>
              </span>
            </a>
          </div>
        @endif
        
      </div>

    </div>
  </section>

<!-- Modal -->
  <div class="modal fade" id="modal-explain" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-title" id="exampleModalLongTitle">Explaining</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="create-explain" enctype="multipart/form-data">
          <div class="modal-body">
            <p>Give your explanation after finish this level</p>
                <div class="form-group">
                    <label>Explanation <span style="color:red">*</span></label>
                    <textarea required class="form-control" name="explanation" style="height:36.5%" placeholder="Write your explanation"></textarea>
                </div>
            <input type="hidden" value="{{$course->id}}" id ="course_id" name="course_id"></input>
            <input type="hidden" value="{{$level->id}}" id="level_id">
          </div>
          <div class="modal-footer">
            <button type="button" id="submit-explain" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
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
    var dataHeight = scrollElement.scrollHeight;

    // Set tinggi elemen scrollable berdasarkan tinggi data
    var manipulationHeight = dataHeight - 15;
    scrollElement.style.height = manipulationHeight + "px";

    scrollElement.addEventListener('scroll', function() {
        if (scrollElement.scrollTop + scrollElement.clientHeight >= scrollElement.scrollHeight) {
            // Panggil fungsi untuk melakukan tindakan saat scroll mencapai bagian bawah
            scoreRead();
            $('#button-test').removeClass('disabled');
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
        url: "{{config('app.python_api')}}",
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
    $('#create-explain').submit(function(e){
            e.preventDefault();
            var level = $('#level_id').val();
            var course = $('#course_id').val();
            var url =  "{{ route('student_course.explain', ":level") }}"
            url = url.replace(':level', level);

            var redirect = "{{route('student_course.level', ":course_id") }}";
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
