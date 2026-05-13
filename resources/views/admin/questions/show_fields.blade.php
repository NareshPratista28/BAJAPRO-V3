<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $question->id }}</p>
</div>

<!-- Content Id Field -->
<div class="form-group">
    {!! Form::label('content_id', 'Content Id:') !!}
    <p>{{ $question->content->title }}</p>
</div>

<!-- Question Field -->
<div class="form-group">
    {!! Form::label('question', 'Question:') !!}
    <p>{!! $question->question !!}</p>
</div>

<!-- Hint Field -->
<div class="form-group">
    {!! Form::label('hint', 'Hint:') !!}
    <p>{{ $question->hint }}</p>
</div>
@foreach ($essay as $essay)
    <!-- Essay question Field -->
    <div class="form-group">
        {!! Form::label('essay_question', 'Essay Question:') !!}
        <p>{{ $essay->question }}</p>
    </div>

    <!-- Key answer Field -->
    <div class="form-group">
        {!! Form::label('key_answer', 'Key Answer 1:') !!}
        <p>{{ $essay->answer }}</p>
    </div>

    <!-- Key answer Field -->
    <div class="form-group">
        {!! Form::label('key_answer2', 'Key Answer 2:') !!}
        <p>{{ $essay->answer2 }}</p>
    </div>

    <!-- Key answer Field -->
    <div class="form-group">
        {!! Form::label('key_answer3', 'Key Answer 3:') !!}
        <p>{{ $essay->answer3 }}</p>
    </div>

    <!-- Key answer Field -->
    <div class="form-group">
        {!! Form::label('key_answer4', 'Key Answer 4:') !!}
        <p>{{ $essay->answer4 }}</p>
    </div>
@endforeach
<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $question->image }}</p>
</div>

<!-- Score Field -->
<div class="form-group">
    {!! Form::label('score', 'Score:') !!}
    <p>{{ $question->score }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $question->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $question->updated_at }}</p>
</div>
