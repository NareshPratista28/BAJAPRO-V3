<style>
    .ql-snow .ql-editor pre.ql-syntax {
        background-color: #f3f3f3;
        color: #1f1f1f;
        overflow: visible;
    }
</style>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Lesson Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lesson_id', 'Lesson:') !!}
    {!! Form::select('lesson_id', $lessons, null, ['class' => 'form-control']) !!}
</div>

<!-- Url Video Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url_video', 'Url Video:') !!}
    {!! Form::text('url_video', null, ['class' => 'form-control']) !!}
</div>

<!-- Published Field -->
<div class="form-group col-sm-6">
    {!! Form::label('published', 'Published:') !!}
    {!! Form::number('published', null, ['class' => 'form-control']) !!}
</div>

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
            {!! @$content->description !!}
        </div>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('prompt_llm', 'Question Example:') !!} {!! Form::hidden('prompt_llm', null, ['class' => 'form-control', 'id' => 'prompt_res']) !!}

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
            <div id="prompt_editor">{!! @$content->prompt_llm !!}</div>
        </div>
    </div>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.contents.index') }}" class="btn btn-light">Cancel</a>
</div>



@section('scripts')
    <script type="text/javascript">
        hljs.configure({ // optionally configure hljs
            languages: ['javascript', 'ruby', 'python']
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

        var promptQuill = new Quill("#prompt_editor", {
            modules: {
                syntax: true,
                toolbar: "#prompt_toolbar",
            },
            theme: "snow",
        });

        quill.on('editor-change', function() {
            document.getElementById("res").value = quill.root.innerHTML;
        });

        promptQuill.on("editor-change", function() {
            document.getElementById("prompt_res").value =
                promptQuill.root.innerHTML;
        });

        // Event untuk Generate Prompt button jika diperlukan
        $("#generatePromptButton").click(function(e) {
            e.preventDefault();
            // Logika untuk menghasilkan prompt
            // Misalnya dengan API call atau logika lainnya
        });
    </script>
@endsection
