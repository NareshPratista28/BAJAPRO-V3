<style>
    .ql-snow .ql-editor pre.ql-syntax {
        background-color: #f3f3f3;
        color: #1f1f1f;
        overflow: visible;
    }
</style>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!} {!! Form::text('title', null,
    ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!} {!!
    Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Example Questions Field (LLM Prompt) -->
<div class="form-group col-sm-12">
    {!! Form::label('prompt_llm', 'Example Question (Prompt LLM):') !!} {!!
    Form::hidden('prompt_llm', null, ['class' => 'form-control', 'id' =>
    'prompt_res']) !!}

    <div class="d-flex align-items-start">
        <div class="flex-grow-1">
            <div id="prompt_toolbar">
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
            <div id="prompt_editor">{!! @$question->prompt_llm !!}</div>
        </div>
    </div>
</div>

<!-- Course Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('course_id', 'Course:') !!} {!! Form::select('course_id',
    $courses, null, ['class' => 'form-control']) !!}
</div>
<!-- level Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level_id', 'Level:') !!} {!! Form::select('level_id',
    $level, null, ['class' => 'form-control']) !!}
</div>

<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('posisition', 'Posisition:') !!} {!!
    Form::number('posisition', null, ['class' => 'form-control']) !!}
</div>

<!-- Published Field -->
<div class="form-group col-sm-6">
    {!! Form::label('published', 'Published:') !!} {!! Form::number('published',
    null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.lessons.index') }}" class="btn btn-light"
        >Cancel</a
    >
</div>

@section('scripts')
<script>
    // (script yang sudah ada tetap dipertahankan)

    // Inisialisasi Quill untuk prompt LLM
    var promptQuill = new Quill("#prompt_editor", {
        modules: {
            syntax: true,
            toolbar: "#prompt_toolbar",
        },
        theme: "snow",
    });

    // Tambahkan event listener untuk prompt LLM
    promptQuill.on("editor-change", function () {
        document.getElementById("prompt_res").value =
            promptQuill.root.innerHTML;
    });

    // Event untuk Generate Prompt button jika diperlukan
    $("#generatePromptButton").click(function (e) {
        e.preventDefault();
        // Logika untuk menghasilkan prompt
        // Misalnya dengan API call atau logika lainnya
    });

    // (script lainnya tetap ada)
</script>
@endsection
