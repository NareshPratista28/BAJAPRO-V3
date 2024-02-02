@extends('layouts.front')

@section('content')
<div class="section-body pb-2">
    <h2 class="section-title">Start Your Lesson now</h2>
    <p class="section-lead">
        levels serve as milestones that learners can progress through, providing structure, motivation, and rewards.<br />

    </p>
    <!-- Your content goes here -->
</div>
<div class="row">
    @foreach($level as $level)
        <div class="col-md-4">
            <div class="card text-center" style="width: 18rem;">
                @php
                    $level_down = $level->id - 1;
                    $lessons1 = \App\Models\Lesson::where('level_id', $level_down)->pluck('id');
                    $content1 = \App\Models\Content::whereIn('lesson_id', $lessons1)->pluck('id');
                    $question1 = \App\Models\Question::whereIn('content_id', $content1)->pluck('id')->toArray();
                    
                    $firstContent = $level->lessons->first()->contents->first();
                    $check = \App\Models\UserScore::where('user_id', Auth::user()->id)->where('level_id', $level_down)->orderBy('question_id', 'asc')->pluck('question_id')->toArray();

                    $diff = array_diff($question1, $check);
                    if(empty($diff)){
                        $is_pass = 1;
                    } else{
                        $is_pass =0;
                    }

                    $check_explain = \App\Models\Explains::where("user_id", Auth::id())->where('level_id', $level_down)->where('code', 0)->count();
                @endphp
                <div class="card-body d-flex flex-column">
                    {{--level 1 selalu dapat diakses--}}
                        @if($level->id == 1)
                            <div class="text-center">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h9V6q0-1.25-.875-2.125T12 3q-1.025 0-1.813.613T9.126 5.15q-.125.375-.388.613T8.126 6q-.5 0-.8-.338t-.2-.762Q7.5 3.225 8.85 2.112T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17Z"/></svg>
                                </span>
                            </div>
                            <h5 class="card-title pt-3">{{$level->name}}</h5>
                            <p class="card-text">{{$level->description}}</p>
                            <a href="{{ route('student_course.my_course.detail.content', [$course_id, $level->id, $firstContent->id]) }}" class="btn btn-primary btn-lg mt-auto" role="button" aria-disabled="true">Start Lesson</a>
                        @else
                        {{--selain level 1 harus melalui pengecekan. apakah semua question di dalam level telah dikerjakan. jika ya, level terbuka--}}
                            @if($is_pass == 1)
                                <div class="text-center">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h9V6q0-1.25-.875-2.125T12 3q-1.025 0-1.813.613T9.126 5.15q-.125.375-.388.613T8.126 6q-.5 0-.8-.338t-.2-.762Q7.5 3.225 8.85 2.112T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17Z"/></svg>
                                    </span>
                                </div>
                                <h5 class="card-title pt-3">{{$level->name}}</h5>
                                <p class="card-text">{{$level->description}}</p>
                                <a href="{{ route('student_course.my_course.detail.content', [$course_id, $level->id, $firstContent->id]) }}" class="btn btn-primary btn-lg mt-auto" role="button" aria-disabled="true">Start Lesson</a>
                            {{--@elseif($is_pass == 1 && $check_explain == 0)
                                <div class="text-center">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h1V6q0-2.075 1.463-3.538T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17ZM9 8h6V6q0-1.25-.875-2.125T12 3q-1.25 0-2.125.875T9 6v2Z"/></svg>
                                    </span>
                                </div>
                                <h5 class="card-title pt-3">{{$level->name}}</h5>
                                <p class="card-text">{{$level->description}}</p>
                                <input type="hidden" value="{{$course_id}}" id="course_id">                                
                                <input type="hidden" value="{{$level->id}}" id="level_id">
                                <input type="hidden" value="{{$firstContent->id}}" id="first_content">
                                <span class="mt-auto" tabindex="0" data-toggle="tooltip" title="You must click and fill the form first">
                                    <button type="button" style="width:100%; height:45px" class="btn btn-secondary" data-toggle="modal" data-target="#modal-explain"> Start Lesson </button>
                                </span>--}}
                            @else
                        {{--jika tidak, level tertutup--}}
                                <div class="text-center">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h1V6q0-2.075 1.463-3.538T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm6-5q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17ZM9 8h6V6q0-1.25-.875-2.125T12 3q-1.25 0-2.125.875T9 6v2Z"/></svg>
                                    </span>
                                </div>
                                <h5 class="card-title pt-3">{{$level->name}}</h5>
                                <p class="card-text">{{$level->description}}</p>
                                <span class="mt-auto" tabindex="0" data-toggle="tooltip" title="You must finish your previous task first">
                                    <a href="javascript:void(0)" style="width:100%; height:45px" class="btn btn-secondary btn-lg mt-auto" role="button" aria-disabled="true">Start Lesson</a>
                                </span>
                            @endif
                        @endif
                </div>
            </div>
        </div>
    @endforeach

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
            <p>You must fill this form to open next level</p>
                <div class="form-group">
                    <label>Explanation <span style="color:red">*</span></label>
                    <textarea required class="form-control" name="explanation" style="height:36.5%" placeholder="Write your explanation"></textarea>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="submit-explain" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script>
        $('#create-explain').submit(function(e){
            e.preventDefault();
            var level = $('#level_id').val();
            var course = $('#course_id').val();
            var first_content = $('#first_content').val();
            var level_down = level - 1;
            var url =  "{{ route('student_course.explain', ":level_down") }}"
            url = url.replace(':level_down', level_down);

            var redirect = "{{ route('student_course.my_course.detail.content', [":course_id", ":level", ":first_content"]) }}";
            redirect = redirect.replace(':course_id', course);
            redirect = redirect.replace(':level', level);
            redirect = redirect.replace(":first_content", first_content);

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
