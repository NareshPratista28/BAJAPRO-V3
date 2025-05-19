@extends('layouts.front')
@section('title')
    Explanation
@endsection
@section('content')
    <style>
        table {
            border-collapse: separate;
            border-spacing: 0 2em;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
    <div class="section-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="section-title mb-2">
                    @if ($title == 'summary')
                        Summary Explanation
                    @else
                        Code Explanation
                    @endif
                </h2>
                <p class="section-lead mb-0">
                    In this page, you will be able to read the explanation done by you
                </p>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></div>
                <div class="breadcrumb-item active">Explanation</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    @if ($title == 'summary')
                                        <th scope="col">Level</th>
                                    @else
                                        <th scope="col">Content</th>
                                    @endif
                                    <th scope="col">Question</th>
                                    <th scope="col">Your Answer</th>
                                    <th scope="col">Answer Key</th>
                                    <th scope="col">Score</th>
                                    {{-- <th scope="col">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($explain as $data)
                                    @php
                                        $check_rubrik = \App\Models\ExplainingScore::where(
                                            'user_answer_id',
                                            $data->id,
                                        )->count();
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
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->essay->questions->content->title }}</td>
                                        <td>{!! $data->essay->question !!}
                                            {{-- @if ($data->edited_admin != null)
                                    <div class="text-right" style="color:red; font-size: 10px">Edited by admin</div>
                                    @endif --}}
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
                    @include('stisla-templates::common.paginate', ['records' => $explain])
                </div>

            </div>
        </div>
    </div>
@endsection
