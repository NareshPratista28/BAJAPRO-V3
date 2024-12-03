@extends('layouts.report')

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

        .table-responsive {
            overflow-x: auto;
        }
    </style>
    <div style="margin-top: 70px">
        <div class="row">
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

            <div class="col-md-5 p-5">
                <div>
                    <h3 class="card-title">Exercise</h3>
                    {!! $question->question !!}
                </div><br />


                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Question</th>
                                        <th scope="col">Your Answer</th>
                                        <th scope="col">Answer Key</th>
                                        <th scope="col">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($explain as $data)
                                        @php
                                            // $check_rubrik = \App\Models\ExplainingScore::where(
                                            //     'user_answer_id',
                                            //     $data->id,
                                            // )->count();
                                            // $explaining = \App\Models\ExplainingScore::where(
                                            //     'user_answer_id',
                                            //     $data->id,
                                            // )->first();
                                            $explaining = \App\Models\ExplainingScore::where('user_id', $data->user->id)
                                            ->where('question_id', $data->essay->questions->id)
                                            ->where('content_id', $data->essay->questions->content->id)
                                            ->where('is_accepted', true)
                                            ->first();
                                        @endphp
                                        <tr class="spacer">
                                            <td>{!! $data->essay->question !!}

                                            </td>
                                            <td>{{ $data->answer }}</td>
                                            {{-- @if ($check_rubrik > 0)
                                                <td>{{ $data->essay->answer }}</td>
                                            @endif --}}
                                            <td>
                                                @if ($explaining)
                                                    {{ $data->essay->answer }}
                                                @else
                                                    Not Available
                                                @endif
                                            </td>
                                            <td>
                                                @if ($explaining?->konteks_penjelasan)
                                                    {{ $explaining?->konteks_penjelasan }}
                                                @elseif($explaining?->keruntutan)
                                                    {{ $explaining?->keruntutan }}
                                                @elseif($explaining?->kebenaran)
                                                    {{ $explaining?->kebenaran }}
                                                @else
                                                    Not Scored
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                {{-- </div>
                </div> --}}
                <br>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/codeflask.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
@endsection
