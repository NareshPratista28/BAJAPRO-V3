<!-- filepath: c:\Projects\Skripsi\BAJAPRO-V3\resources\views\admin\history\show.blade.php -->
@extends('layouts.app')

@section('title')
    Generation Log Details
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">LLM Generation Details</h3>
            <div class="section-header-breadcrumb">
                <a href="{{ route('admin.history.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $history['topic_title'] ?? 'Generation Details' }}</h4>
                            <div class="card-header-action">
                                <span
                                    class="badge badge-primary">{{ date('Y-m-d H:i:s', strtotime($history['created_at'] ?? 'now')) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <strong>Content ID:</strong>
                                    @if (isset($history['content_id']))
                                        <a href="{{ route('admin.contents.show', $history['content_id']) }}">
                                            {{ $history['content_id'] }}
                                        </a>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Generation Time:</strong>
                                    {{ number_format($history['generation_time'] ?? 0, 2) }} seconds
                                </div>
                            </div>

                            @if (isset($history['prompt']))
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Prompt</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="prompt-content p-3 bg-light rounded">
                                            {!! nl2br(e($history['prompt'])) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Result</h5>
                                </div>
                                <div class="card-body">
                                    @if (is_array($history['result'] ?? null))
                                        @php
                                            $result = $history['result'];
                                            $hasCode = isset($result['code']);
                                            $hasStudiKasus = isset($result['studi_kasus']);
                                            $hasTugas = isset($result['tugas']);
                                        @endphp

                                        <div class="bg-white rounded p-4 mb-3 shadow-sm">
                                            @if ($hasStudiKasus)
                                                <div class="mb-3">
                                                    <h5 class="font-weight-bold">Studi Kasus:</h5>
                                                    <p>{{ $result['studi_kasus'] }}</p>
                                                </div>
                                            @endif

                                            @if ($hasTugas)
                                                <div class="mb-3">
                                                    <h5 class="font-weight-bold">Tugas:</h5>
                                                    <div>{!! nl2br(e($result['tugas'])) !!}</div>
                                                </div>
                                            @endif

                                            @if ($hasCode)
                                                <div>
                                                    <h5 class="font-weight-bold">Code:</h5>
                                                    <div id="result-code-editor" class="code-editor-container"></div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div id="result-editor" class="code-result-container">{!! $history['result'] ?? 'No result data available' !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .prompt-content,
    .response-content {
        white-space: pre-wrap;
        font-family: monospace;
        max-height: 400px;
        overflow-y: auto;
    }

    .response-content {
        border-left: 4px solid #6777ef;
    }

    pre {
        background: transparent;
        margin: 0;
        padding: 0;
        font-family: monospace;
        white-space: pre-wrap;
    }

    /* Code highlighting styles */
    .code-result-container,
    .code-editor-container {
        border: 1px solid #e9ecef;
        border-radius: 4px;
        height: auto;
        min-height: 200px;
        background-color: #f8f9fa;
    }

    .ql-editor {
        padding: 12px 15px;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
        font-size: 14px;
        line-height: 1.5;
    }

    .ql-editor pre.ql-syntax {
        background-color: #282c34;
        color: #abb2bf;
        overflow: visible;
        padding: 15px;
        border-radius: 4px;
    }

    /* Remove focus outline on readonly editor */
    .ql-container.ql-disabled .ql-editor:focus {
        outline: none;
    }

    /* Better field styling */
    .font-weight-bold {
        font-weight: 600;
    }
</style>

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure highlight.js
            hljs.configure({
                languages: ['javascript', 'ruby', 'python', 'java', 'php', 'html', 'css']
            });

            @if (is_array($history['result'] ?? null) && isset($history['result']['code']))
                // Initialize Code editor for structured result with code field
                var codeEditor = new Quill('#result-code-editor', {
                    modules: {
                        syntax: true,
                        toolbar: false
                    },
                    theme: 'snow',
                    readOnly: true
                });

                // Insert the code and format it
                var code = @json($history['result']['code']);
                codeEditor.setText('');
                codeEditor.insertText(0, code);
                codeEditor.formatLine(0, code.length, 'code-block', 'java');
            @else
                // Initialize general result editor for non-structured results
                var resultEditor = new Quill('#result-editor', {
                    modules: {
                        syntax: true,
                        toolbar: false
                    },
                    theme: 'snow',
                    readOnly: true
                });

                // Process the content for code formatting
                var content = resultEditor.root.innerHTML;
                if (content.indexOf('<pre') === -1 && content.indexOf('<code') === -1) {
                    // If no code formatting exists, try to detect and format code
                    var codePattern = /```([a-z]*)\n([\s\S]*?)```/g;
                    var match;

                    if ((match = codePattern.exec(content)) !== null) {
                        // Markdown code block found
                        var language = match[1] || 'javascript';
                        var code = match[2];

                        // Clear editor and insert formatted code
                        resultEditor.setText('');
                        resultEditor.insertText(0, code);
                        resultEditor.formatLine(0, code.length, 'code-block', true);
                    } else if (content.indexOf('{') === 0 || content.indexOf('[') === 0) {
                        // Looks like JSON, format it
                        try {
                            var jsonObj = JSON.parse(content);
                            var formatted = JSON.stringify(jsonObj, null, 2);
                            resultEditor.setText('');
                            resultEditor.insertText(0, formatted);
                            resultEditor.formatLine(0, formatted.length, 'code-block', true);
                        } catch (e) {
                            // Not valid JSON, leave as is
                        }
                    }
                }
            @endif

            // Make all editors read-only
            document.querySelectorAll('.ql-editor').forEach(function(editor) {
                editor.setAttribute('contenteditable', 'false');
            });

            // Add specific class for read-only styling
            document.querySelectorAll('.ql-container').forEach(function(container) {
                container.classList.add('ql-disabled');
            });
        });
    </script>
@endsection
