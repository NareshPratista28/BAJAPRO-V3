<style>
    .ql-snow .ql-editor {
        max-width: 100%;
    }

    .ql-snow .ql-editor pre.ql-syntax {
        background-color: #f3f3f3;
        color: #1f1f1f;
        overflow-x: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 100%;
        padding: 12px;
        border-radius: 4px;
        box-sizing: border-box;
        tab-size: 4;
    }

    .ql-snow .ql-editor pre.ql-syntax::-webkit-scrollbar {
        height: 6px;
    }

    .btn-generate {
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 12px;
    }

    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-generate:active {
        transform: translateY(1px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .btn-generate .fa-magic {
        transform: rotate(-15deg);
    }

    .btn-generate .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<!-- Content Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('content_id', 'Content Id:') !!} {!! Form::select('content_id', $contents, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('question_name', 'Question Name:') !!} {!! Form::text('question_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Question Field -->
<div class="form-group col-sm-12">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            {!! Form::label('question', 'Code Question:', ['class' => 'mb-0']) !!}
        </div>
        <div>
            <button id="generateQuestionButton" class="btn btn-success btn-generate">
                <i class="fas fa-magic mr-2"></i>Generate Question
            </button>
        </div>
    </div>
    {!! Form::hidden('question', null, ['class' => 'form-control', 'id' => 'res']) !!}

    <div class="d-flex align-items-start">
        <div class="flex-grow-1">
            <div id="toolbar">
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
            <div id="editor">{!! @$question->question !!}</div>
        </div>
    </div>
</div>

<!-- Hint Field -->
{{--
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('hint', 'Hint:') !!} {!! Form::textarea('hint', null,
    ['class' => 'form-control']) !!}
</div>
--}}

<div class="col-sm-12 col-lg-12 p-0" id="inputFieldsContainer">
    @if ($title == 'edit')
        @foreach ($essay as $key => $data)
            <div class="custom-group">
                <div class="d-flex flex-row">
                    <div class="col-sm-10">
                        <label for="essay_question1">Essay Question :</label>
                        <textarea type="text" name="essay_question[]" class="form-control" style="height: 200px"
                            value="{{ $data->question }}">{{ $data->question }}</textarea
                >
                <label for="answer_key1">Answer Key 1:</label>
                <textarea
                    type="text"
                    name="answer_key[]"
                    value="{{ $data->answer }}"
                    style="height: 200px"
                    class="form-control"
                    >{{ $data->answer }}</textarea
                >
                <label for="answer_key2">Answer Key 2:</label>
                <textarea
                    type="text"
                    name="answer_key2[]"
                    value="{{ $data->answer2 }}"
                    style="height: 200px"
                    class="form-control"
                    >{{ $data->answer2 }}</textarea
                >
                <label for="answer_key3">Answer Key 3:</label>
                <textarea
                    type="text"
                    name="answer_key3[]"
                    value="{{ $data->answer3 }}"
                    style="height: 200px"
                    class="form-control"
                    >{{ $data->answer3 }}</textarea
                >
                <label for="answer_key4">Answer Key 4:</label>
                <textarea
                    type="text"
                    name="answer_key4[]"
                    value="{{ $data->answer4 }}"
                    style="height: 200px"
                    class="form-control"
                    >{{ $data->answer4 }}</textarea
                >
                <input type="hidden" value="{{ $data->id }}" name="essay_id[]" />
            </div>
            <div class="col-sm-2 pt-3">
                <a
                    href="#"
                    id="removeButton"
                    class="removeButton btn btn-danger mt-3"
                    >Remove <b>-</b></a
                >
            </div>
        </div>
    </div>
@endforeach
@else
<div class="custom-group">
        <div class="d-flex flex-row">
            <div class="col-sm-10">
                <label for="essay_question1">Essay Question :</label>
                <textarea
                    type="text"
                    name="essay_question[]"
                    style="height: 200px"
                    class="form-control"
                ></textarea>
                        <label for="answer_key1">Answer Key 1:</label>
                        <textarea type="text" name="answer_key[]" style="height: 200px" class="form-control"></textarea>
                        <label for="answer_key2">Answer Key 2:</label>
                        <textarea type="text" name="answer_key2[]" style="height: 200px" class="form-control"></textarea>
                        <label for="answer_key3">Answer Key 3:</label>
                        <textarea type="text" name="answer_key3[]" style="height: 200px" class="form-control"></textarea>
                        <label for="answer_key4">Answer Key 4:</label>
                        <textarea type="text" name="answer_key4[]" style="height: 200px" class="form-control"></textarea>
                        <input type="hidden" value="0" name="essay_id[]" />
                    </div>
                    <div class="col-sm-2 pt-3">
                        <a href="#" id="removeButton" class="removeButton btn btn-danger mt-3">Remove
                            <b>-</b></a>
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
    {!! Form::label('image', 'Image:') !!} {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>

<!-- Score Field -->
<div class="form-group col-sm-3">
    {!! Form::label('score', 'Score:') !!} {!! Form::number('score', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('is_essay', 'Code:') !!} {!! Form::checkbox('is_essay', '1') !!}
</div>

{{--
<div class="form-group col-sm-3">
    {!! Form::label('timer', 'Timer: (minutes)') !!} {!! Form::number('timer',
    null, ['class' => 'form-control']) !!}
</div>

<div class="form-divider" />

<div class="col-sm-12" id="answer_list">
    <div class="card-title">Answers</div>
    <div class="row">
        @for ($i = 0; $i < 4; $i++)
        <div class="col-sm-10">
            <textarea
                class="form-control"
                rows="3"
                name="answers_{{ $i }}"
                placeholder="Answer {{ $i + 1 }}"
                >{{ @$answers[$i]->answer }}</textarea
            >
        </div>
        <div class="col-md-2">
            <input
                type="hidden"
                name="answer_id_{{ $i }}"
                value="{{ @$answers[$i]->id }}"
            />
            <input
                type="checkbox"
                value="true"
                name="is_right_{{ $i }}"
                {{
                @$answers[$i]-
            />is_right == 'true' ? 'checked' : '' }}> is right?
        </div>
        <div class="form-divider"></div>
        @endfor
    </div>
</div>
--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary" id="submitButton">
        Save
    </button>
    <a href="{{ route('admin.questions.index') }}" class="btn btn-light">Cancel</a>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            var counter = 1;

            $("#expandButton").click(function() {
                counter++;

                var inputField =
                    '<div class="custom-group">' +
                    '<div class="d-flex flex-row">' +
                    '<div class="col-sm-10">' +
                    '<label for="essay_question' +
                    counter +
                    '">Essay Question  :</label>' +
                    '<textarea type="text" name="essay_question[]" style="height: 200px;" class="form-control"></textarea>' +
                    '<label for="answer_key1' +
                    counter +
                    '">Answer Key 1:</label>' +
                    '<textarea type="text" name="answer_key[]" style="height: 200px;" class="form-control"></textarea>' +
                    '<label for="answer_key2' +
                    counter +
                    '">Answer Key 2:</label>' +
                    '<textarea type="text" name="answer_key2[]" style="height: 200px;" class="form-control"></textarea>' +
                    '<label for="answer_key3' +
                    counter +
                    '">Answer Key 3:</label>' +
                    '<textarea type="text" name="answer_key3[]" style="height: 200px;" class="form-control"></textarea>' +
                    '<label for="answer_key4' +
                    counter +
                    '">Answer Key 4:</label>' +
                    '<textarea type="text" name="answer_key4[]" style="height: 200px;" class="form-control"></textarea>' +
                    '<input type="hidden" value="0" name="essay_id[]">' +
                    "</div>" +
                    '<div class="col-sm-2 pt-3">' +
                    '<a href="#" id="removeButton" class="removeButton btn btn-danger mt-3">Remove <b>-</b></a>' +
                    "</div>" +
                    "</div>";

                $("#inputFieldsContainer").append(inputField);
            });

            $(document).on("click", ".removeButton", function(event) {
                event.preventDefault();

                var fieldGroup = $(this).closest(".custom-group");

                // Hapus 2 field inputan sekaligus
                fieldGroup.next(".custom-group").remove();
                fieldGroup.remove();
            });

            document.getElementById('generateQuestionButton').addEventListener('click', async function(e) {
                e.preventDefault();

                const contentId = document.querySelector('select[name="content_id"]').value;
                const generateBtn = this;
                const originalText = generateBtn.innerHTML;

                try {
                    // Show loading state
                    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
                    generateBtn.disabled = true;

                    const response = await fetch(
                        `http://localhost:8001/api/v1/generate-question/${contentId}`);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    // Clear the editor first
                    quill.setText('');

                    // Format content in proper structure
                    // Add "Studi Kasus" section
                    quill.insertText(0, 'Studi Kasus:', {
                        'bold': true
                    });
                    quill.insertText(quill.getLength(), '\n\n');

                    // Handle multi-paragraph studi kasus text
                    const studiKasusText = data.studi_kasus || '';
                    const studiKasusParas = studiKasusText.split('\n\n');
                    studiKasusParas.forEach((para, index) => {
                        if (para.trim() !== '') {
                            quill.insertText(quill.getLength(), para.trim());
                            if (index < studiKasusParas.length - 1) {
                                quill.insertText(quill.getLength(), '\n\n');
                            }
                        }
                    });

                    quill.insertText(quill.getLength(), '\n\n');

                    // Format tasks as bullet points
                    const tugasText = data.tugas || '';
                    if (tugasText.includes('- ') || tugasText.includes('• ')) {
                        // Already has bullet points, preserve them but standardize format
                        const lines = tugasText.split('\n').filter(line => line.trim() !== '');
                        lines.forEach(line => {
                            // Convert either "- " or "• " to the bullet format you prefer
                            const formattedLine = line.trim().replace(/^-\s|^•\s/, '');
                            quill.insertText(quill.getLength(), '• ' + formattedLine);
                            quill.insertText(quill.getLength(), '\n');
                        });
                    } else {
                        // Convert lines to bullet points
                        const lines = tugasText.split('\n').filter(line => line.trim() !== '');
                        lines.forEach(line => {
                            quill.insertText(quill.getLength(), '• ' + line.trim());
                            quill.insertText(quill.getLength(), '\n');
                        });
                    }

                    quill.insertText(quill.getLength(), '\n');

                    // Add code block
                    if (data.code) {
                        const codeBlockIndex = quill.getLength();
                        quill.insertText(codeBlockIndex, data.code);
                        quill.formatLine(codeBlockIndex, data.code.length, 'code-block', true);
                    }

                    // Update hidden input with HTML content
                    document.getElementById('res').value = quill.root.innerHTML;

                } catch (error) {
                    console.error('Error:', error);
                    alert('Error generating question: ' + error.message);
                } finally {
                    // Reset button state
                    generateBtn.innerHTML = originalText;
                    generateBtn.disabled = false;
                }
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
            });

            hljs.configure({
                // optionally configure hljs
                languages: ["javascript", "ruby", "python", "java"],
            });

            var quill = new Quill("#editor", {
                modules: {
                    syntax: true,
                    toolbar: "#toolbar",
                },
                theme: "snow",
                onChange: (value) => {
                    console.log(value);
                },
            });

            quill.on("editor-change", function() {
                document.getElementById("res").value = quill.root.innerHTML;
            });
        });
    </script>
@endsection
