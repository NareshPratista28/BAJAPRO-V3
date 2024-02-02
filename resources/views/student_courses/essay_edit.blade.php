@extends('layouts.front')
@section('content')
<div class="section-body pb-2">
    <h2 class="section-title">Explanation</h2>
    <p class="section-lead">
        In this page, you will be able to read the explanation of level from another user<br />

    </p>
    <!-- Your content goes here -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('essay.update', [$user_answer->id]) }}" id="myForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $user_answer->user->name }}</p>
                        </div>

                        <!-- Content Field -->
                        <div class="form-group col-sm-6">
                        {!! Form::label('content_id', 'Content:') !!}
                        <p>{{ $user_answer->essay->questions->content->title }}</p>
                        </div>

                        <!-- Description Field -->
                        <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('your_answer', 'Your Answer:') !!}
                        <textarea name="answer"  style="height: 200px;" class="form-control">{{ $user_answer->answer}}</textarea>

                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection