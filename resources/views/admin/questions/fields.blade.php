<style>
    .ql-snow .ql-editor {
        max-width: 100%;
        line-height: 1.6;
    }

    .ql-snow .ql-editor pre.ql-syntax {
        background-color: #f8f9fa;
        color: #1f1f1f;
        overflow-x: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 100%;
        padding: 15px;
        border-radius: 8px;
        box-sizing: border-box;
        tab-size: 4;
        margin: 10px 0;
        border: 1px solid #e9ecef;
        font-size: 14px;
        line-height: 1.5;
    }

    .ql-snow .ql-editor pre.ql-syntax::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .ql-snow .ql-editor pre.ql-syntax::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .ql-snow .ql-editor pre.ql-syntax::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .btn-generate {
        border-radius: 8px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 12px;
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 8px 16px;
    }

    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        background: linear-gradient(45deg, #20c997, #17a2b8);
        color: white;
    }

    .btn-generate:active {
        transform: translateY(1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .btn-generate:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-generate .fa-magic {
        transform: rotate(-15deg);
        transition: transform 0.3s ease;
    }

    .btn-generate:hover .fa-magic {
        transform: rotate(0deg);
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

    .custom-group {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .custom-group:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-color: #dee2e6;
    }

    .removeButton {
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: linear-gradient(45deg, #dc3545, #c82333);
        border: none;
        color: white;
    }

    .removeButton:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        background: linear-gradient(45deg, #c82333, #bd2130);
        color: white;
    }

    #expandButton {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: linear-gradient(45deg, #17a2b8, #007bff);
        border: none;
        color: white;
        padding: 10px 20px;
    }

    #expandButton:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background: linear-gradient(45deg, #007bff, #6f42c1);
        color: white;
    }

    .alert-success {
        border-radius: 8px;
        border: none;
        background: linear-gradient(45deg, #d4edda, #c3e6cb);
    }

    .alert-error {
        border-radius: 8px;
        border: none;
        background: linear-gradient(45deg, #f8d7da, #f5c6cb);
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-content {
        background: white;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .btn-generate.btn-info {
        background: linear-gradient(45deg, #17a2b8, #007bff);
    }

    .btn-generate.btn-info:hover {
        background: linear-gradient(45deg, #007bff, #6f42c1);
        color: white;
    }

    .dynamic-files-status {
        margin-top: 15px;
        padding: 10px;
        border-radius: 6px;
        background: #e3f2fd;
        border: 1px solid #90caf9;
        display: none;
    }

    .dynamic-files-status.success {
        background: #e8f5e8;
        border-color: #4caf50;
        color: #2e7d32;
    }

    .dynamic-files-status.error {
        background: #ffebee;
        border-color: #f44336;
        color: #c62828;
    }

    .file-path-display {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', monospace;
        font-size: 12px;
        background: rgba(0, 0, 0, 0.05);
        padding: 4px 8px;
        border-radius: 4px;
        margin: 2px 0;
        word-break: break-all;
    }
</style>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-content">
        <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
        <h4>Generating Question...</h4>
    </div>
</div>

<!-- Content Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('content_id', 'Pilih Content/Materi:', ['class' => 'required']) !!}
    {!! Form::select('content_id', $contents, null, [
        'class' => 'form-control select2',
        'placeholder' => 'Pilih content',
        'required' => true,
    ]) !!}
    <small class="form-text text-muted">Pilih materi pembelajaran</small>
</div>

<!-- Question Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('question_name', 'Nama Soal:', ['class' => 'required']) !!}
    {!! Form::text('question_name', null, [
        'class' => 'form-control',
        'placeholder' => 'Masukkan nama soal...',
        'required' => true,
    ]) !!}
    <small class="form-text text-muted">Berikan nama untuk soal ini</small>
</div>

<!-- Question Content Field -->
<div class="form-group col-sm-12">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            {!! Form::label('question', 'Konten Soal (Studi Kasus + Code):', ['class' => 'mb-0 required']) !!}
            <small class="form-text text-muted">Konten soal akan di-generate otomatis oleh AI</small>
        </div>
        <div>
            <button id="generateQuestionButton" type="button" class="btn btn-info btn-generate">
                <i class="fas fa-file-code mr-2"></i>Generate Question
            </button>
        </div>
    </div>

    {!! Form::hidden('question', null, ['id' => 'questionHidden']) !!}
    {!! Form::hidden('test_cases_data', null, ['id' => 'testCasesData']) !!}
    {!! Form::hidden('solution_template', null, ['id' => 'solutionTemplate']) !!}
    {!! Form::hidden('junit_tests', null, ['id' => 'junitTests']) !!} <div class="editor-container">
        <div id="toolbar">
            <select class="ql-header">
                <option value="1">Heading 1</option>
                <option value="2">Heading 2</option>
                <option value="3">Heading 3</option>
                <option selected>Normal</option>
            </select>
            <button class="ql-bold" title="Bold"></button>
            <button class="ql-italic" title="Italic"></button>
            <button class="ql-underline" title="Underline"></button>
            <button class="ql-list" value="ordered" title="Numbered List"></button>
            <button class="ql-list" value="bullet" title="Bullet List"></button>
            <button class="ql-code-block" title="Code Block"></button>
            <button class="ql-clean" title="Remove Formatting"></button>
        </div>
        <div id="editor" style="min-height: 300px;">{!! @$question->question !!}</div>
    </div>

    <!-- Dynamic Files Status Section -->
    <div id="dynamicFilesStatus" class="dynamic-files-status">
        <h6><i class="fas fa-file-code mr-2"></i>Dynamic Files Generation Status</h6>
        <div id="dynamicFilesContent"></div>
    </div>
</div>

<!-- Essay Questions Section -->
<div class="col-sm-12 col-lg-12 p-0" id="inputFieldsContainer">
    <h5 class="mb-3">
        <i class="fas fa-edit mr-2"></i>Essay Questions
    </h5>

    @if ($title == 'edit')
        @foreach ($essay as $key => $data)
            <div class="custom-group">
                <div class="d-flex flex-row">
                    <div class="col-sm-10">
                        <label>Essay Question {{ $key + 1 }}:</label>
                        <textarea name="essay_question[]" class="form-control" style="height: 150px" placeholder="Masukkan pertanyaan essay...">{{ $data->question }}</textarea>

                        <label class="mt-3">Answer Key 1:</label>
                        <textarea name="answer_key[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci pertama...">{{ $data->answer }}</textarea>

                        <label class="mt-2">Answer Key 2:</label>
                        <textarea name="answer_key2[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci kedua...">{{ $data->answer2 }}</textarea>

                        <label class="mt-2">Answer Key 3:</label>
                        <textarea name="answer_key3[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci ketiga...">{{ $data->answer3 }}</textarea>

                        <label class="mt-2">Answer Key 4:</label>
                        <textarea name="answer_key4[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci keempat...">{{ $data->answer4 }}</textarea>

                        <input type="hidden" value="{{ $data->id }}" name="essay_id[]" />
                    </div>
                    <div class="col-sm-2 pt-3 text-center">
                        <a href="#" class="removeButton btn btn-danger btn-sm">
                            <i class="fas fa-trash mr-1"></i>Remove
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="custom-group">
            <div class="d-flex flex-row">
                <div class="col-sm-10">
                    <label>Essay Question 1:</label>
                    <textarea name="essay_question[]" style="height: 150px" class="form-control" placeholder="Masukkan pertanyaan essay..."></textarea>

                    <label class="mt-3">Answer Key 1:</label>
                    <textarea name="answer_key[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci pertama..."></textarea>

                    <label class="mt-2">Answer Key 2:</label>
                    <textarea name="answer_key2[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci kedua..."></textarea>

                    <label class="mt-2">Answer Key 3:</label>
                    <textarea name="answer_key3[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci ketiga..."></textarea>

                    <label class="mt-2">Answer Key 4:</label>
                    <textarea name="answer_key4[]" style="height: 120px" class="form-control" placeholder="Jawaban kunci keempat..."></textarea>

                    <input type="hidden" value="0" name="essay_id[]" />
                </div>
                <div class="col-sm-2 pt-3 text-center">
                    <a href="#" class="removeButton btn btn-danger btn-sm">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="form-group col-sm-12 pt-3">
    <button type="button" id="expandButton" class="btn btn-info">
        <i class="fas fa-plus mr-2"></i>Add Essay Question
    </button>
</div>

<!-- Additional Fields -->
<div class="row">
    <!-- Image Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('image', 'Upload Image (Optional):') !!}
        {!! Form::file('image', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
        <small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
    </div>

    <!-- Score Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('score', 'Score/Point:') !!}
        {!! Form::number('score', null, [
            'class' => 'form-control',
            'min' => 1,
            'max' => 1000,
            'placeholder' => 'Contoh: 100',
        ]) !!}
        <small class="form-text text-muted">Score untuk soal code yang didapat jika jawaban benar</small>
    </div>

    <!-- Code Checkbox -->
    <div class="form-group col-sm-4">
        <label class="d-block">Jenis Soal:</label>
        <div class="form-check">
            {!! Form::checkbox('is_essay', '1', null, ['class' => 'form-check-input', 'id' => 'is_essay']) !!}
            <label class="form-check-label" for="is_essay">
                <i class="fas fa-code mr-1"></i>Soal Coding/Programming
            </label>
        </div>
        <small class="form-text text-muted">Centang jika ini adalah soal programming</small>
    </div>
</div>

<!-- Submit Buttons -->
<div class="form-group col-sm-12 mt-4">
    <div class="d-flex justify-content-between">
        <div>
            <button type="submit" class="btn btn-primary btn-lg mr-3" id="submitButton">
                <i class="fas fa-save mr-2"></i>Save Question
            </button>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">

    <script>
        // Global variables
        let quill;
        let questionCounter = 1;

        $(document).ready(function() {
            initializeEditor();
            initializeEventHandlers();

            // Initialize Select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    placeholder: 'Pilih content untuk generate soal...',
                    allowClear: true
                });
            }
        });

        /**
         * Initialize Quill Rich Text Editor
         */
        function initializeEditor() {
            // Configure highlight.js
            hljs.configure({
                languages: ['java', 'javascript', 'python', 'html', 'css']
            });

            // Initialize Quill with enhanced configuration
            quill = new Quill('#editor', {
                modules: {
                    syntax: {
                        highlight: text => hljs.highlightAuto(text).value
                    },
                    toolbar: '#toolbar'
                },
                theme: 'snow',
                placeholder: 'Konten soal akan muncul di sini setelah generate...'
            });

            // Update hidden field when content changes
            quill.on('text-change', function() {
                document.getElementById('questionHidden').value = quill.root.innerHTML;
            });

            // Set initial content if editing
            const initialContent = document.getElementById('questionHidden').value;
            if (initialContent && initialContent.trim() !== '') {
                quill.root.innerHTML = initialContent;
            }
        }

        /**
         * Initialize all event handlers
         */
        function initializeEventHandlers() {
            // Generate question button
            document.getElementById('generateQuestionButton').addEventListener('click', handleGenerateQuestion);

            // Expand button for essay questions
            document.getElementById('expandButton').addEventListener('click', handleAddEssayQuestion);

            // Remove button event delegation
            $(document).on('click', '.removeButton', handleRemoveEssayQuestion);

            // Form submission
            // $('form').on('submit', handleFormSubmit);

            // Essay checkbox change
            $('#is_essay').on('change', handleEssayCheckboxChange);
        }

        /**
         * Create JUnit file SETELAH question berhasil disimpan di database
         */
        async function createJUnitFileAfterSave(questionId) {
            try {
                console.log('🔥 Starting JUnit file creation for question_id:', questionId);

                // Get stored data from sessionStorage
                const pendingData = sessionStorage.getItem('pendingJUnitData');
                console.log('📋 PendingJUnitData from sessionStorage:', pendingData ? 'Found' : 'Not found');

                if (!pendingData) {
                    console.warn('⚠️ No pending JUnit data found in sessionStorage');
                    showAlert('warning', '⚠️ Tidak ada data JUnit untuk disimpan. Silakan generate ulang soal.');
                    return;
                }

                const junitData = JSON.parse(pendingData);
                console.log('📊 JUnit data to save:', {
                    question_id: questionId,
                    class_name: junitData.class_name,
                    has_junit_code: !!junitData.junit_test_code,
                    junit_code_length: junitData.junit_test_code ? junitData.junit_test_code.length : 0
                });

                const requestPayload = {
                    junit_test_code: junitData.junit_test_code,
                    class_name: junitData.class_name,
                    question_id: questionId
                };

                console.log('🌐 Making request to JUnit save API:', `{{ config('app.llm_save_junit_file') }}`);
                console.log('📦 Request payload:', requestPayload);

                // Call Django API untuk save JUnit file
                const response = await fetch(`{{ config('app.llm_save_junit_file') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestPayload)
                });

                console.log('📡 JUnit API response:', {
                    status: response.status,
                    statusText: response.statusText,
                    ok: response.ok
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('✅ JUnit file created successfully:', result);

                    // Clean up sessionStorage
                    sessionStorage.removeItem('pendingJUnitData');
                    console.log('🗑️ Cleaned up sessionStorage');

                    showAlert('success', '✅ Soal berhasil disimpan dan JUnit test file dibuat!');
                } else {
                    const errorText = await response.text();
                    console.error('❌ Failed to create JUnit file:', {
                        status: response.status,
                        statusText: response.statusText,
                        errorText: errorText
                    });
                    showAlert('warning', '⚠️ Soal berhasil disimpan tapi JUnit file gagal dibuat. Error: ' + errorText);
                }

            } catch (error) {
                console.error('❌ Error in createJUnitFileAfterSave:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack
                });
                showAlert('warning', '⚠️ Soal berhasil disimpan tapi JUnit file gagal dibuat: ' + error.message);
            }
        }

        /**
         * Enhanced code formatting function to prevent bracket issues
         */
        function fixCodeFormatting(code) {
            if (!code || typeof code !== 'string') {
                return code;
            }

            try {
                // Split into lines for processing
                let lines = code.split('\n');
                let processedLines = [];
                let braceStack = [];

                for (let i = 0; i < lines.length; i++) {
                    let line = lines[i];
                    let trimmed = line.trim();

                    // Skip empty lines but preserve intentional spacing
                    if (trimmed === '' && i < lines.length - 1) {
                        processedLines.push(line);
                        continue;
                    }

                    // Handle isolated closing brackets
                    if (trimmed === '}') {
                        // Check if this is the last line and should be merged
                        if (i === lines.length - 1 && processedLines.length > 0) {
                            // Find the appropriate line to attach this bracket
                            let attachIndex = processedLines.length - 1;

                            // Look for the last non-empty line
                            while (attachIndex >= 0 && processedLines[attachIndex].trim() === '') {
                                attachIndex--;
                            }

                            if (attachIndex >= 0) {
                                // Get proper indentation
                                let indent = getProperIndentation(processedLines, attachIndex);
                                processedLines.push(indent + '}');
                            } else {
                                processedLines.push(line);
                            }
                        } else {
                            processedLines.push(line);
                        }
                    } else {
                        processedLines.push(line);
                    }
                }

                // Join lines and clean up excessive whitespace
                let result = processedLines.join('\n');

                // Remove excessive empty lines (max 2 consecutive)
                result = result.replace(/\n\s*\n\s*\n/g, '\n\n');

                // Ensure proper bracket formatting
                result = result.replace(/\}\s*\n\s*$/g, '\n}');

                return result.trim();

            } catch (error) {
                console.error('Error fixing code formatting:', error);
                return code;
            }
        }

        /**
         * Get proper indentation for brackets
         */
        function getProperIndentation(lines, lineIndex) {
            // Look for class or method declarations to match indentation
            for (let i = lineIndex; i >= 0; i--) {
                let line = lines[i].trim();
                if (line.includes('class ') || line.includes('public ') || line.includes('private ') || line.includes(
                        'protected ')) {
                    // Get the indentation of this line
                    let matches = lines[i].match(/^(\s*)/);
                    return matches ? matches[1] : '';
                }
            }
            return '';
        }
        /**
         * Enhanced generate question with JUnit handler - calls Laravel controller method
         */
        async function handleGenerateQuestion(e) {
            e.preventDefault();

            const contentId = document.querySelector('select[name="content_id"]').value;
            const generateBtn = document.getElementById('generateQuestionButton');
            const originalText = generateBtn.innerHTML;

            // Validation
            if (!contentId || contentId === "") {
                showAlert('error', 'Harap pilih content/materi terlebih dahulu!');
                return;
            }

            try {
                // Show loading state
                showLoadingOverlay(true);
                generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating Question & JUnit...';
                generateBtn.disabled = true;

                // Get content information for context
                const contentSelect = document.querySelector('select[name="content_id"]');
                const selectedText = contentSelect.options[contentSelect.selectedIndex].text;

                console.log('🚀 Generating question with JUnit for content:', selectedText);
                console.log('📋 Content ID:', contentId);

                // Call Laravel controller method to generate question with JUnit
                const response = await fetch('{{ route('admin.questions.generate-with-junit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || ''
                    },
                    body: JSON.stringify({
                        content_id: contentId,
                        topic: selectedText,
                        context: `Materi pembelajaran: ${selectedText}`,
                        requirements: 'Generate soal pemrograman Java dengan JUnit test'
                    })
                });

                console.log('📡 Response status:', response.status);
                console.log('📡 Response ok:', response.ok);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ Response error:', {
                        status: response.status,
                        statusText: response.statusText,
                        body: errorText
                    });

                    let errorMessage = `HTTP error! status: ${response.status}`;
                    try {
                        const errorData = JSON.parse(errorText);
                        errorMessage = errorData.error || errorData.message || errorMessage;
                    } catch (e) {
                        errorMessage = errorText || errorMessage;
                    }

                    throw new Error(errorMessage);
                }

                const result = await response.json();
                console.log('✅ Question and JUnit generated:', result);

                if (result.success && result.data) {
                    const questionData = result.data;

                    // Populate the editor with generated question
                    populateQuillEditor(questionData);

                    // Fill hidden fields with generated data
                    document.getElementById('testCasesData').value = JSON.stringify(questionData.test_cases || []);
                    document.getElementById('solutionTemplate').value = questionData.solution_template || '';
                    document.getElementById('junitTests').value = questionData.junit_test_code || '';

                    // Auto-fill question name if empty
                    const questionNameField = document.querySelector('input[name="question_name"]');
                    if (!questionNameField.value.trim()) {
                        questionNameField.value = `Latihan: ${selectedText}`;
                    }

                    // Store for potential future use
                    sessionStorage.setItem('generatedQuestionData', JSON.stringify({
                        content_id: contentId,
                        question_data: questionData,
                        generated_at: new Date().toISOString()
                    }));

                    // Show success message
                    showAlert('success', '✅ Soal dan JUnit test berhasil di-generate! Silakan review dan simpan.');

                    // Show dynamic files status
                    showDynamicFilesStatus(questionData, null);

                } else {
                    throw new Error(result.message || 'Failed to generate question');
                }

            } catch (error) {
                console.error('Error generating question:', error);
                showAlert('error', `❌ Error: ${error.message}`);
                showDynamicFilesStatus(null, error.message);
            } finally {
                // Reset button state and remove progress indicator
                generateBtn.innerHTML = originalText;
                generateBtn.disabled = false;
                showLoadingOverlay(false);
            }
        }

        /**
         * Setup form submission handler dengan proper debugging
         */
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔄 DOM Content Loaded - Setting up form handler');

            const form = document.querySelector('form');
            console.log('📋 Form element found:', !!form);

            if (form) {
                console.log('✅ Adding submit event listener to form');

                form.addEventListener('submit', function(e) {
                    console.log('🚀 Form submit event triggered!');
                    console.log('📝 Form action:', form.action);
                    console.log('📊 Form method:', form.method);

                    e.preventDefault();

                    // Perform validation dengan logging
                    const contentId = document.querySelector('select[name="content_id"]').value;
                    const questionName = document.querySelector('input[name="question_name"]').value;
                    const questionContent = quill.getText().trim();

                    console.log('🔍 Validation data:', {
                        contentId: contentId,
                        questionName: questionName,
                        contentLength: questionContent.length
                    });

                    if (!contentId) {
                        console.warn('❌ Validation failed: No content_id');
                        showAlert('error', 'Harap pilih content/materi!');
                        return false;
                    }

                    if (!questionName.trim()) {
                        console.warn('❌ Validation failed: No question_name');
                        showAlert('error', 'Harap isi nama soal!');
                        return false;
                    }

                    if (!questionContent || questionContent.length < 10) {
                        console.warn('❌ Validation failed: Content too short');
                        showAlert('error', 'Konten soal terlalu pendek!');
                        return false;
                    }

                    console.log('✅ Validation passed - Proceeding with form submission');

                    // Show loading
                    const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector(
                        '#submitButton');
                    console.log('🔘 Submit button found:', !!submitBtn);

                    if (submitBtn) {
                        const originalBtnText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                        submitBtn.disabled = true;
                        console.log('🔄 Submit button state changed to loading');

                        // Update hidden field dengan latest quill content
                        document.getElementById('questionHidden').value = quill.root.innerHTML;
                        console.log('📝 Updated hidden field with quill content');

                        // Submit form via AJAX dengan detailed logging
                        const formData = new FormData(form);

                        // Log form data untuk debugging
                        console.log('📦 Form data entries:');
                        for (let [key, value] of formData.entries()) {
                            if (key === 'question') {
                                console.log(`   ${key}: [HTML content - ${value.length} chars]`);
                            } else if (typeof value === 'string' && value.length > 100) {
                                console.log(`   ${key}: [Large content - ${value.length} chars]`);
                            } else {
                                console.log(`   ${key}:`, value);
                            }
                        }

                        console.log('🌐 Making AJAX request to:', form.action);

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute('content') || ''
                                }
                            })
                            .then(response => {
                                console.log('📡 Response received:', {
                                    status: response.status,
                                    statusText: response.statusText,
                                    ok: response.ok,
                                    headers: Object.fromEntries(response.headers.entries())
                                });

                                if (!response.ok) {
                                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('📝 Form submission response data:', data);

                                if (data.success && data.question_id) {
                                    console.log('✅ Question saved successfully with ID:', data
                                        .question_id);

                                    // Create JUnit file dengan question_id yang valid
                                    createJUnitFileAfterSave(data.question_id).then(() => {
                                        console.log('📁 JUnit file creation completed');
                                        // Redirect after JUnit file creation
                                        setTimeout(() => {
                                            console.log('🔄 Redirecting to:', data
                                                .redirect || '/admin/questions');
                                            window.location.href = data.redirect ||
                                                '/admin/questions';
                                        }, 1500);
                                    });
                                } else {
                                    throw new Error(data.message ||
                                        'Question save failed - no success flag or question_id');
                                }
                            })
                            .catch(error => {
                                console.error('❌ Form submission error:', error);
                                console.error('Error details:', {
                                    message: error.message,
                                    stack: error.stack
                                });

                                showAlert('error', 'Error saving question: ' + error.message);

                                // Reset submit button
                                submitBtn.innerHTML = originalBtnText;
                                submitBtn.disabled = false;
                                console.log('🔄 Submit button state reset');
                            });
                    } else {
                        console.error('❌ Submit button not found!');
                    }

                    return false;
                });
            } else {
                console.error('❌ Form element not found in DOM!');
            }
        });

        /**
         * Populate Quill editor with generated data
         */
        function populateQuillEditor(data) {
            // Clear editor first
            quill.setText('');

            // Add structured content with better formatting
            if (data.studi_kasus) {
                let index = quill.getLength() - 1;
                quill.insertText(index, 'Studi Kasus:\n', {
                    'bold': true,
                    'size': '18px',
                });
                
                index = quill.getLength() - 1;
                quill.insertText(index, data.studi_kasus.trim() + '\n\n');
            }

            if (data.tugas) {
                let index = quill.getLength() - 1;
                quill.insertText(index, 'Tugas:\n', {
                    'bold': true,
                    'size': '18px',
                });
                
                const tasks = data.tugas.split('\n').filter(line => line.trim() !== '');
                tasks.forEach((task, idx) => {
                    let cleanTask = task.trim().replace(/^[\-\*\+•]\s*/, '');
                    cleanTask = cleanTask.replace(/^\d+\.\s*/, '');
                    
                    let idxToInsert = quill.getLength() - 1;
                    quill.insertText(idxToInsert, `${idx + 1}. ${cleanTask}\n`);
                });
                
                let spacingIndex = quill.getLength() - 1;
                quill.insertText(spacingIndex, '\n');
            }

            if (data.code && data.code.trim()) {
                let index = quill.getLength() - 1;
                quill.insertText(index, 'Code Template:\n', {
                    'bold': true,
                    'size': '18px'
                });

                let cleanCode = fixCodeFormatting(data.code.trim());
                if (!cleanCode.endsWith('\n')) {
                    cleanCode += '\n';
                }

                index = quill.getLength() - 1;
                quill.insertText(index, cleanCode);
                
                // Format code block including the trailing newline to keep brace inside
                quill.formatText(index, cleanCode.length, 'code-block', true);
            }

            // Update hidden field
            document.getElementById('questionHidden').value = quill.root.innerHTML;
        }

        /**
         * Extract class name from Java code
         */
        function extractClassNameFromCode(code) {
            if (!code) return null;

            const classMatch = code.match(/public\s+class\s+(\w+)/);
            if (classMatch) return classMatch[1];

            const fallbackMatch = code.match(/class\s+(\w+)/);
            return fallbackMatch ? fallbackMatch[1] : null;
        }

        /**
         * Handle adding new essay question
         */
        function handleAddEssayQuestion(e) {
            e.preventDefault();
            questionCounter++;

            const newQuestionHtml = `
                <div class="custom-group">
                    <div class="d-flex flex-row">
                        <div class="col-sm-10">
                            <label>Essay Question ${questionCounter}:</label>
                            <textarea name="essay_question[]" style="height: 150px" class="form-control"
                                      placeholder="Masukkan pertanyaan essay..."></textarea>
                            
                            <label class="mt-3">Answer Key 1:</label>
                            <textarea name="answer_key[]" style="height: 120px" class="form-control"
                                      placeholder="Jawaban kunci pertama..."></textarea>
                            
                            <label class="mt-2">Answer Key 2:</label>
                            <textarea name="answer_key2[]" style="height: 120px" class="form-control"
                                      placeholder="Jawaban kunci kedua..."></textarea>
                            
                            <label class="mt-2">Answer Key 3:</label>
                            <textarea name="answer_key3[]" style="height: 120px" class="form-control"
                                      placeholder="Jawaban kunci ketiga..."></textarea>
                            
                            <label class="mt-2">Answer Key 4:</label>
                            <textarea name="answer_key4[]" style="height: 120px" class="form-control"
                                      placeholder="Jawaban kunci keempat..."></textarea>
                            
                            <input type="hidden" value="0" name="essay_id[]" />
                        </div>
                        <div class="col-sm-2 pt-3 text-center">
                            <a href="#" class="removeButton btn btn-danger btn-sm">
                                <i class="fas fa-trash mr-1"></i>Remove
                            </a>
                        </div>
                    </div>
                </div>
            `;

            $('#inputFieldsContainer').append(newQuestionHtml);
            showAlert('success', 'Essay question berhasil ditambahkan!');
        }

        /**
         * Handle removing essay question
         */
        function handleRemoveEssayQuestion(e) {
            e.preventDefault();

            const essayGroups = document.querySelectorAll('.custom-group');
            if (essayGroups.length > 1) {
                $(this).closest('.custom-group').fadeOut(300, function() {
                    $(this).remove();
                    showAlert('info', 'Essay question berhasil dihapus.');
                });
            } else {
                showAlert('error', 'Tidak dapat menghapus essay question terakhir!');
            }
        }

        /**
         * Handle form submission
         */
        function handleFormSubmit(e) {
            // Update hidden field before submission
            document.getElementById('questionHidden').value = quill.root.innerHTML;

            // Basic validation
            const contentId = document.querySelector('select[name="content_id"]').value;
            const questionName = document.querySelector('input[name="question_name"]').value;
            const questionContent = quill.getText().trim();

            if (!contentId) {
                e.preventDefault();
                showAlert('error', 'Harap pilih content/materi!');
                return false;
            }

            if (!questionName.trim()) {
                e.preventDefault();
                showAlert('error', 'Harap isi nama soal!');
                return false;
            }

            if (!questionContent || questionContent.length < 10) {
                e.preventDefault();
                showAlert('error', 'Konten soal terlalu pendek! Silakan generate atau isi manual.');
                return false;
            }

            // Show loading
            const submitBtn = document.getElementById('submitButton');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            submitBtn.disabled = true;

            // Set up post-submission handler
            setupPostSubmissionHandler();

            return true;
        }

        /**
         * Setup handler untuk setelah form submission berhasil
         */
        function setupPostSubmissionHandler() {
            // Listen for form submission success
            // Ini akan dijalankan setelah redirect dari form submission
            const form = document.querySelector('form');

            // Override form action untuk handle response
            const originalAction = form.action;

            // Convert form submission to AJAX for better control
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const formData = new FormData(form);

                    const response = await fetch(originalAction, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        // Form berhasil disimpan, sekarang buat JUnit file
                        const result = await response.json();
                        const questionId = result.question_id; // Assuming Laravel returns question_id

                        if (questionId) {
                            await createJUnitFileAfterSave(questionId);
                        }

                        // Redirect ke index atau show success
                        window.location.href = response.url || '/admin/questions';
                    } else {
                        throw new Error('Form submission failed');
                    }

                } catch (error) {
                    console.error('Form submission error:', error);
                    showAlert('error', 'Error saving question: ' + error.message);

                    // Reset submit button
                    const submitBtn = document.getElementById('submitButton');
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Question';
                    submitBtn.disabled = false;
                }
            });
        }

        /**
         * Create JUnit file SETELAH question berhasil disimpan di database
         */
        async function createJUnitFileAfterSave(questionId) {
            try {
                console.log('Creating JUnit file for question_id:', questionId);

                // Get stored data from sessionStorage
                const pendingData = sessionStorage.getItem('pendingJUnitData');
                if (!pendingData) {
                    console.log('No pending JUnit data found');
                    return;
                }

                const junitData = JSON.parse(pendingData);
                console.log('📋 JUnit data to save:', {
                    question_id: questionId,
                    class_name: junitData.class_name,
                    has_junit_code: !!junitData.junit_test_code
                });

                // Call Django API untuk save JUnit file
                const response = await fetch(`{{ config('app.llm_save_junit_file') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        junit_test_code: junitData.junit_test_code,
                        class_name: junitData.class_name,
                        question_id: questionId
                    })
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('✅ JUnit file created:', result);

                    // Clean up sessionStorage
                    sessionStorage.removeItem('pendingJUnitData');

                    // Show success message
                    showAlert('success', '✅ Soal berhasil disimpan dan JUnit test file dibuat!');
                } else {
                    console.error('❌ Failed to create JUnit file:', await response.text());
                    showAlert('warning',
                        '⚠️ Soal berhasil disimpan tapi JUnit file gagal dibuat. Silakan hubungi admin.');
                }

            } catch (error) {
                console.error('❌ Error creating JUnit file:', error);
                showAlert('warning', '⚠️ Soal berhasil disimpan tapi JUnit file gagal dibuat: ' + error.message);
            }
        }

        /**
         * Handle essay checkbox change
         */
        function handleEssayCheckboxChange() {
            const isChecked = $(this).is(':checked');
            // Add any specific logic for essay vs multiple choice questions
        }

        /**
         * Show loading overlay
         */
        function showLoadingOverlay(show) {
            const overlay = document.getElementById('loadingOverlay');
            if (show) {
                overlay.style.display = 'flex';
            } else {
                overlay.style.display = 'none';
            }
        }

        /**
         * Show alert messages
         */
        function showAlert(type, message) {
            // Remove existing alerts
            $('.alert').remove();

            const alertClass = type === 'error' ? 'alert-danger' : `alert-${type}`;
            const iconClass = type === 'error' ? 'fas fa-exclamation-triangle' :
                type === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="${iconClass} mr-2"></i>${message}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `;

            // Insert after the form header
            $('.form-group').first().before(alertHtml);

            // Auto-dismiss after 5 seconds for success messages
            if (type === 'success') {
                setTimeout(() => {
                    $('.alert').fadeOut();
                }, 5000);
            }

            // Scroll to alert
            $('html, body').animate({
                scrollTop: $('.alert').offset().top - 100
            }, 300);
        }

        /**
         * Show dynamic files generation status
         */
        function showDynamicFilesStatus(result, errorMessage = null) {
            console.log('showDynamicFilesStatus called with:', result, errorMessage);

            const statusDiv = document.getElementById('dynamicFilesStatus');
            const contentDiv = document.getElementById('dynamicFilesContent');

            if (!statusDiv || !contentDiv) {
                console.error('Dynamic files status elements not found');
                return;
            }

            if (errorMessage) {
                // Show error status
                statusDiv.className = 'dynamic-files-status error';
                contentDiv.innerHTML = `
                    <div class="mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Error generating files:</strong>
                    </div>
                    <div class="alert alert-danger mb-0">
                        ${errorMessage}
                    </div>
                `;
                statusDiv.style.display = 'block';
                return;
            }

            if (!result || !result.data) {
                console.warn('No result data provided to showDynamicFilesStatus');
                statusDiv.style.display = 'none';
                return;
            } // Check if file_generation exists
            const fileGen = result.data.file_generation;
            if (!fileGen) {
                console.warn('No file_generation data in result');
                statusDiv.style.display = 'none';
                return;
            }

            const filesCreated = result.files_created || {};

            // Additional safety check - ensure filesCreated has the expected properties
            if (!filesCreated.java_template && fileGen.java_file_path) {
                filesCreated.java_template = fileGen.java_file_path;
            }
            if (!filesCreated.junit_test && fileGen.junit_file_path) {
                filesCreated.junit_test = fileGen.junit_file_path;
            }
            if (!filesCreated.solution_template && fileGen.solution_file_path) {
                filesCreated.solution_template = fileGen.solution_file_path;
            }
            if (!filesCreated.package_directory && fileGen.package_directory) {
                filesCreated.package_directory = fileGen.package_directory;
            }

            console.log('Final filesCreated object:', filesCreated);

            // Show success status
            statusDiv.className = 'dynamic-files-status success';

            let statusHtml = `                <div class="mb-3">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Files berhasil dibuat!</strong>
                    <span class="badge badge-success ml-2">Package: ${fileGen.package_name || 'Unknown'}</span>
                    <span class="badge badge-info ml-1">Class: ${fileGen.class_name || 'Unknown'}</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Generated Files:</h6>                        <div class="file-path-display">
                            <i class="fas fa-file-code text-primary mr-1"></i>
                            <strong>Java Template:</strong><br>
                            <small class="text-muted">${filesCreated.java_template || 'File path not available'}</small>
                        </div>
                        <div class="file-path-display">
                            <i class="fas fa-vial text-warning mr-1"></i>
                            <strong>JUnit Test:</strong><br>
                            <small class="text-muted">${filesCreated.junit_test || 'File path not available'}</small>
                        </div>
                        <div class="file-path-display">
                            <i class="fas fa-lightbulb text-info mr-1"></i>
                            <strong>Solution Template:</strong><br>
                            <small class="text-muted">${filesCreated.solution_template || 'File path not available'}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Generation Details:</h6>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-clock text-muted mr-2"></i>Generation Time: ${(result.data.file_generation && result.data.file_generation.generation_time) || result.data.generation_time || 0} seconds</li>
                            <li><i class="fas fa-folder text-muted mr-2"></i>Package Directory: <small class="text-muted">${filesCreated.package_directory || 'Path not available'}</small></li>
                            <li><i class="fas fa-database text-muted mr-2"></i>History ID: ${(result.data.file_generation && result.data.file_generation.history_id) || 'N/A'}</li>
                        </ul>
                        
                        <div class="mt-3">
                            <h6 class="text-muted mb-2">Test Components:</h6>
                            <div class="d-flex flex-wrap">
                                ${result.data.test_cases ? `<span class="badge badge-warning mr-1 mb-1">🧪 ${result.data.test_cases.length} Test Cases</span>` : ''}
                                ${result.data.junit_test_code ? `<span class="badge badge-secondary mr-1 mb-1">⚡ JUnit Tests</span>` : ''}
                                ${result.data.solution_template ? `<span class="badge badge-info mr-1 mb-1">💡 Solution Template</span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 pt-2 border-top">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Files telah dibuat di direktori online-compiler dan siap untuk digunakan untuk testing.
                        Mahasiswa dapat submit jawaban mereka dan sistem akan otomatis menjalankan JUnit test yang telah dibuat.
                    </small>
                </div>
            `;

            contentDiv.innerHTML = statusHtml;
            statusDiv.style.display = 'block';

            // Smooth scroll to status
            setTimeout(() => {
                statusDiv.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 100);
        }
    </script>
@endsection
