@extends('layouts.front')
@section('content')
<style>
table{
  border-collapse:separate; 
  border-spacing: 0 2em;
}
</style>
<div class="section-body pb-2">
    @if($title == "summary")
        <h2 class="section-title">Summary Explanation</h2>
    @else
        <h2 class="section-title">Code Explanation</h2>
    @endif
    <p class="section-lead">
        In this page, you will be able to read the explanation done by you<br />

    </p>
    <!-- Your content goes here -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        @if($title == "summary")
                            <th scope="col">Level</th>
                        @else
                            <th scope="col">Content</th>
                        @endif
                        <th scope="col">Question</th>
                        <th scope="col">Your Answer</th>
                        <th scope="col">Answer Key</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($explain as $data)
                            @php
                                $check_rubrik = \App\Models\ExplainingScore::where('user_answer_id', $data->id)->count();
                            @endphp
                            <tr class="spacer">
                                <td>{{$data->user->name}}</td>
                                <td>{{$data->essay->questions->content->title}}</td>
                                <td>{!! $data->essay->question !!}
                                    {{--@if($data->edited_admin != null)
                                    <div class="text-right" style="color:red; font-size: 10px">Edited by admin</div>
                                    @endif--}}
                                </td>
                                <td>{{$data->answer}}</td>
                                @if($check_rubrik > 0)
                                    <td>{{$data->essay->answer}}</td>
                                    <td></td>
                                @else
                                    <td>-</td>
                                    <td class=" text-center">
                                        <div class='btn-group'>
                                            <a href="{!! route('student_course.essay.edit', [$data->id]) !!}" type="button" style="height:50px" class="btn btn-warning mt-auto">
                                                <i class="fa fa-edit"></i></a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('stisla-templates::common.paginate', ['records' => $explain])
            </div>
        </div>
    </div>
</div>
@endsection