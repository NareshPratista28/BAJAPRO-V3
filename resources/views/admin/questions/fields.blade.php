<style>
  .ql-snow .ql-editor pre.ql-syntax {
    background-color: #f3f3f3;
    color: #1f1f1f;
    overflow: visible;
  }
</style>

<!-- Content Id Field -->
<div class="form-group col-sm-12">
  {!! Form::label('content_id', 'Content Id:') !!}
  {!! Form::select('content_id', $contents, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
  {!! Form::label('question_name', 'Question Name:') !!}
  {!! Form::text('question_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Question Field -->
<div class="form-group col-sm-12">
  {!! Form::label('question', 'Code Question:') !!}
  {!! Form::hidden('question', null, ['class' => 'form-control', 'id' => 'res']) !!}

  <div class="d-flex align-items-start">
    <div class="flex-grow-1">
      <div id="toolbar">
        <!-- Toolbar buttons tetap sama -->
        <select class="ql-size">
          <option value="small"></option>
          <option selected></option>
          <option value="large"></option>
          <option value="huge"></option>
        </select>
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
        <button class="ql-script" value="sub"></button>
        <button class="ql-script" value="super"></button>
        <button class="ql-image"></button>
        <button class="ql-code-block"></button>
      </div>
      <div id="editor">
        {!! @$question->question !!}
      </div>
    </div>
    <div class="ml-2">
      <button id="generateQuestionButton" class="btn btn-success">
        <i class="fas fa-magic mr-2"></i>Generate Question
      </button>
    </div>
  </div>
</div>

<!-- Hint Field -->
{{--<div class="form-group col-sm-12 col-lg-12">
  {!! Form::label('hint', 'Hint:') !!}
  {!! Form::textarea('hint', null, ['class' => 'form-control']) !!}
</div>--}}

<div class="col-sm-12 col-lg-12 p-0" id="inputFieldsContainer">
  @if($title == "edit")
    @foreach($essay as $key => $data)
      <div class="custom-group">
        <div class="d-flex flex-row">
          <div class="col-sm-10">
            <label for="essay_question1">Essay Question :</label>
            <textarea type="text" name="essay_question[]" class="form-control" style="height: 200px;" value="{{$data->question}}">{{$data->question}}</textarea>
            <label for="answer_key1">Answer Key 1:</label>
            <textarea type="text" name="answer_key[]" value="{{$data->answer}}" style="height: 200px;" class="form-control">{{$data->answer}}</textarea>
            <label for="answer_key2">Answer Key 2:</label>
            <textarea type="text" name="answer_key2[]" value="{{$data->answer2}}" style="height: 200px;" class="form-control">{{$data->answer2}}</textarea>
            <label for="answer_key3">Answer Key 3:</label>
            <textarea type="text" name="answer_key3[]" value="{{$data->answer3}}" style="height: 200px;" class="form-control">{{$data->answer3}}</textarea>
            <label for="answer_key4">Answer Key 4:</label>
            <textarea type="text" name="answer_key4[]" value="{{$data->answer4}}" style="height: 200px;" class="form-control">{{$data->answer4}}</textarea>
            <input type="hidden" value="{{$data->id}}" name="essay_id[]">
          </div>
          <div class="col-sm-2 pt-3">
            <a href="#" id="removeButton" class="removeButton btn btn-danger mt-3">Remove <b>-</b></a>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="custom-group">
      <div class="d-flex flex-row">
        <div class="col-sm-10">
          <label for="essay_question1">Essay Question :</label>
          <textarea type="text" name="essay_question[]" style="height: 200px;" class="form-control"></textarea>
          <label for="answer_key1">Answer Key 1:</label>
          <textarea type="text" name="answer_key[]" style="height: 200px;" class="form-control"></textarea>
          <label for="answer_key2">Answer Key 2:</label>
          <textarea type="text" name="answer_key2[]" style="height: 200px;" class="form-control"></textarea>
          <label for="answer_key3">Answer Key 3:</label>
          <textarea type="text" name="answer_key3[]" style="height: 200px;" class="form-control"></textarea>
          <label for="answer_key4">Answer Key 4:</label>
          <textarea type="text" name="answer_key4[]" style="height: 200px;" class="form-control"></textarea>
          <input type="hidden" value="0" name="essay_id[]">
        </div>
        <div class="col-sm-2 pt-3">
          <a href="#" id="removeButton" class="removeButton btn btn-danger mt-3">Remove <b>-</b></a>
        </div>
      </div>
    </div>
  @endif
</div>
<div class="form-group col-sm-12 pt-3">
  <a href="#" id="expandButton" class="btn btn-success">Expand <b>+</b></a>
  
</div>

<!-- Image Field -->
<div class="form-group col-sm-3">
  {!! Form::label('image', 'Image:') !!}
  {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>

<!-- Score Field -->
<div class="form-group col-sm-3">
  {!! Form::label('score', 'Score:') !!}
  {!! Form::number('score', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
  {!! Form::label('is_essay', 'Code:') !!}
  {!! Form::checkbox('is_essay', '1') !!}
</div>




{{--<div class="form-group col-sm-3">
  {!! Form::label('timer', 'Timer: (minutes)') !!}
  {!! Form::number('timer', null, ['class' => 'form-control']) !!}
</div>

<div class="form-divider" />

<div class="col-sm-12" id="answer_list">
  <div class="card-title">Answers</div>
  <div class="row">
    @for ($i = 0; $i < 4; $i++)
      <div class="col-sm-10">
        <textarea class="form-control" rows="3" name="answers_{{ $i }}"
          placeholder="Answer {{ $i + 1 }}">{{ @$answers[$i]->answer }}</textarea>
      </div>
      <div class="col-md-2">
        <input type="hidden" name="answer_id_{{ $i }}" value="{{ @$answers[$i]->id }}">
        <input type="checkbox" value="true" name="is_right_{{ $i }}"
          {{ @$answers[$i]->is_right == 'true' ? 'checked' : '' }}> is right?
      </div>
      <div class="form-divider"></div>
    @endfor
  </div>

</div>--}}


<!-- Submit Field -->
<div class="form-group col-sm-12">
  <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
  <a href="{{ route('admin.questions.index') }}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
  <script>
    $(document).ready(function() {
        var counter = 1;

        $('#expandButton').click(function() {

            counter++;

            var inputField = 
                '<div class="custom-group">' +
                  '<div class="d-flex flex-row">' +
                  '<div class="col-sm-10">' +
                  '<label for="essay_question' + counter + '">Essay Question  :</label>' +
                  '<textarea type="text" name="essay_question[]" style="height: 200px;" class="form-control"></textarea>' +
                  '<label for="answer_key1' + counter + '">Answer Key 1:</label>' +
                  '<textarea type="text" name="answer_key[]" style="height: 200px;" class="form-control"></textarea>' +
                  '<label for="answer_key2' + counter + '">Answer Key 2:</label>' +
                  '<textarea type="text" name="answer_key2[]" style="height: 200px;" class="form-control"></textarea>' +
                  '<label for="answer_key3' + counter + '">Answer Key 3:</label>' +
                  '<textarea type="text" name="answer_key3[]" style="height: 200px;" class="form-control"></textarea>' +
                  '<label for="answer_key4' + counter + '">Answer Key 4:</label>' +
                  '<textarea type="text" name="answer_key4[]" style="height: 200px;" class="form-control"></textarea>' +
                  '<input type="hidden" value="0" name="essay_id[]">'+
                  '</div>' +
                  '<div class="col-sm-2 pt-3">' +
                  '<a href="#" id="removeButton" class="removeButton btn btn-danger mt-3">Remove <b>-</b></a>' +
                  '</div>' +
                  '</div>';

            $('#inputFieldsContainer').append(inputField);
        });

        $(document).on('click', '.removeButton', function(event) {
            event.preventDefault();

            var fieldGroup = $(this).closest('.custom-group');

            // Hapus 2 field inputan sekaligus
            fieldGroup.next('.custom-group').remove();
            fieldGroup.remove();
        });
    });

    


    if ($("#is_essay").is(":checked")) {
      $("#answer_list").hide();
    }

    $("#is_essay").change(function() {
      let is_checked = $("#is_essay").is(":checked");
      if (is_checked) {
        $("#answer_list").hide();
      } else {
        $("#answer_list").show();
      }
    })

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
