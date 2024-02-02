@extends('layouts.front')
@section('content')
  <div>
    <h3>My report</h3>
    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            Your badge
            <h3>{{ $current_badge->name }} <img src="/image_upload/{{ $current_badge['file'] }}" width="50px"></h3>

          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            Your Score
            <h3>{{ $final_score }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            Your progress
            <h3>{{ $percentage }} %</h3>
            <div class="progress mt-2">
              <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;"
                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $percentage }}%</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            Finished test
            <h3>{{ sizeof($finish_code_tests) }} Test</h3>
          </div>
        </div>
      </div>
    </div><br />

    <h3>Code Test Report</h3>
    @foreach ($code_score as $sc)
      <div class="row mb-1">
        <div class="col-md-12">
          @php
            $q = \App\Models\Question::find($sc->question_id);
            $c = \App\Models\Content::find($sc->content_id);
            $wondering = \App\Models\WonderingScore::where(["user_id" => Auth::id()])->where('content_id', $c->id)->sum("score");
            $exploring = \App\Models\UserScore::where("user_id", Auth::id())->where('question_id', $q->id)->sum("score");
            $score = \App\Models\TotalScore::where('user_id', Auth::id())->where('question_id', $q->id)->sum("score");
            
            $explain = 0;
            if($score != 0){
              $explain = $score - ($wondering + $exploring);
            }

          @endphp

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <h6>{{ $q->question_name }}</h6>
                  Question Name
                </div>

                {{--<div class="col-md-5">
                  @php
                    $f = \Carbon\Carbon::parse($sc->started_at);
                    $t = \Carbon\Carbon::parse($sc->ended_at);
                    $h = $t->diff($f)->format('%Hh %Im %Ss');
                  @endphp

                  <span class="badge badge-info">
                    On Timer {{ $sc->on_timer }}
                  </span>
                  <span class="badge badge-success">
                    Duration: {{ $h }}
                  </span>
                  <br />
                  <div class="mt-1">
                    {{ $sc->started_at }} <i class="fa fa-arrow-right mx-2 text-primary"></i>
                    {{ $sc->ended_at }}
                  </div>
                </div>--}}

                <div class="col-md-1">
                  @php
                    $err = \App\Models\ExerciseCodeLog::where(['user_id' => Auth::id(), 'question_id' => $sc->question_id, 'is_error' => 1]);
                    $sucess = \App\Models\ExerciseCodeLog::where(['user_id' => Auth::id(), 'question_id' => $sc->question_id, 'is_error' => 0])
                  @endphp
                  <span class="badge badge-danger mt-2">
                    {{ $err->count() }} Errors
                  </span><br />
                </div>

                <div class="col-md-1">
                  <span class="badge badge-success mt-2">
                      {{ $sucess->count() }} Success
                  </span><br />
                </div>

                <div class="col-md-2">
                  <span class="badge badge-info mt-2">
                    Read Score: {{ $wondering }}
                  </span>
                </div>

                <div class="col-md-2">
                  <span class="badge badge-info mt-2">
                    Coding Score: {{ $sc->score }}
                  </span>
                </div>

                <div class="col-md-2">
                  <span class="badge badge-info mt-2">
                    Question Score: {{ $explain }}
                  </span>
                </div>

                <div class="col-md-2 " style="text-align:center">
                  <a href="{{ route('student_course.report.detail', ['question_id' => $sc->question_id]) }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
                    <i class="fa fa-info-circle"></i>
                    Detail
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach


  </div>
@endsection
