<style>
  .ql-snow .ql-editor pre.ql-syntax {
    background-color: #f3f3f3;
    color: #1f1f1f;
    overflow: visible;
  }
</style>

<div class="form-group col-sm-6">
  {!! Form::label('name', 'Name:') !!}
  <p>{{ $explain->users->name }}</p>
</div>

@if($title == "summary")
  <!-- level Field -->
  <div class="form-group col-sm-6">
    {!! Form::label('level_id', 'Level:') !!}
    <p>{{ $explain->level->name }}</p>
  </div>
@else
  <!-- Content Field -->
  <div class="form-group col-sm-6">
    {!! Form::label('content_id', 'Content:') !!}
    <p>{{ $explain->question->content->title }}</p>
  </div>
@endif

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
  {!! Form::label('description', 'Description:') !!}
  {!! Form::hidden('description', null, ['class' => 'form-control', 'id' => 'res']) !!}

  <div>
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
      {!! @$explain->description !!}
    </div>
  </div>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
  {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
  <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
  <script>
    hljs.configure({ // optionally configure hljs
      languages: ['javascript', 'ruby', 'python', 'java']
    });

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
    });
  </script>
@endsection
