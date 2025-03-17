<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $lesson->id }}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $lesson->title }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $lesson->description }}</p>
</div>

<!-- Prompt LLM Field -->
<div class="form-group">
    {!! Form::label('prompt_llm', 'Prompt LLM:') !!}
    <p>{{!! $lesson->prompt_llm !!}}</p>
</div>

<!-- Course Id Field -->
<div class="form-group">
    {!! Form::label('course_id', 'Course Id:') !!}
    <p>{{ $lesson->course_id }}</p>
</div>

<!-- Course Id Field -->
<div class="form-group">
    {!! Form::label('level_id', 'Level Id:') !!}
    <p>{{ $lesson->level_id }}</p>
</div>

<!-- Position Field -->
<div class="form-group">
    {!! Form::label('position', 'Position:') !!}
    <p>{{ $lesson->position }}</p>
</div>

<!-- Published Field -->
<div class="form-group">
    {!! Form::label('published', 'Published:') !!}
    <p>{{ $lesson->published }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $lesson->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $lesson->updated_at }}</p>
</div>
