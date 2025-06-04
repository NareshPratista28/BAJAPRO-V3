@extends('layouts.front')

@section('content')

<div class="section-body pb-2">
    <h2 class="section-title">Syntax Conversion</h2>
    <p class="section-lead">
        On this page, you can easily convert Java code to Python.
        <a href="{{ route('syntax-converter.guide') }}" class="btn btn-sm btn-info float-right">
            <i class="fas fa-question-circle"></i> Feature Guide
        </a>
    </p>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Conversion History</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <button id="newConversionBtn" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-plus"></i> New Conversion
                        </button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('syntax-converter.history') }}" class="text-primary">
                            <i class="fas fa-history"></i> View All History
                        </a>
                        <span class="badge badge-primary badge-pill">{{ $conversions->count() }}</span>
                    </li>
                    @forelse($conversions->take(10) as $conversion)
                    <li class="list-group-item">
                        <a href="javascript:void(0)" class="load-conversion" data-id="{{ $conversion->id }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-truncate" style="max-width: 150px;">{{ $conversion->title }}</h6>
                                <small>{{ $conversion->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="list-group-item">No conversion history yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="conversionTitle">Conversion Title</label>
                    <input type="text" class="form-control" id="conversionTitle" placeholder="Enter conversion title (optional)">
                </div>
                
                <!-- Mode Switch Button -->
                <div class="form-group text-right">
                    <div class="d-flex justify-content-between align-items-center">
                        <div id="currentModeIndicator" class="text-primary">
                            <!-- Mode indicator will be set by JavaScript -->
                        </div>
                        <div class="toggle-container">
                            <label class="switch">
                                <input type="checkbox" id="modeToggleInput">
                                <span class="slider round">
                                    <i class="fas fa-graduation-cap beginner-icon"></i>
                                    <i class="fas fa-code expert-icon"></i>
                                </span>
                            </label>
                            <span id="modeSwitchText" class="ml-2"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Java Code Editor (input only, no run/output) -->
                <div class="form-group">
                    <label for="javaCodeEditor"><strong>Java Code</strong></label>
                    <div class="code-container">
                        <textarea id="javaCodeEditor" style="min-height: 300px;"></textarea>
                        <span id="wordCount" class="word-counter">0/50 words</span>
                    </div>
                </div>

                <!-- Convert and Save buttons -->
                <div class="text-center mb-4 button-container">
                    <div>
                        <button id="convertBtn" class="btn btn-primary px-5" type="button">Convert</button>
                        <button id="saveBtn" class="btn btn-success px-5 ml-2" type="button">Save</button>
                        <button id="showExplanationBtn" class="btn btn-info ml-2" type="button">Conversion Explanation</button>
                    </div>
                    <div id="executionTimeDisplay"></div>
                </div>

                <!-- Python Code Editor with Run button -->
                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center">
                        <label><strong>Python Code</strong></label>
                        <button id="runPythonBtn" class="btn btn-info" type="button">
                            <i class="fas fa-play"></i> Run Python
                        </button>
                    </div>
                    <div class="code-container">
                        <textarea id="pythonCodeEditor"></textarea>
                    </div>
                </div>
                
                <!-- Tips Section for Beginner Mode -->
                <div id="tipSection" class="alert alert-light" style="display: none;">
                    <p class="mb-0"><i class="fas fa-lightbulb text-warning"></i> <em id="tipContent">Tips will appear here after conversion in learning mode.</em></p>
                </div>

                <!-- Python Output -->
                <div class="form-group">
                    <label><strong>Python Output</strong></label>
                    <div class="card bg-dark">
                        <div class="card-body">
                            <pre id="pythonOutput" class="text-light p-2" style="min-height: 100px; max-height: 200px; overflow-y: auto;">Output will be displayed here after running Python code.</pre>
                            <div id="pythonInputContainer" class="mt-2" style="display: none;">
                                <div class="input-group">
                                    <input type="text" id="pythonUserInput" class="form-control" placeholder="Enter input...">
                                    <div class="input-group-append">
                                        <button id="pythonSubmitInput" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- New Feedback Section (moved below Python Output) -->
                <div id="feedbackSection" class="text-center mb-4" style="display: none; background-color: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                    <p class="feedback-question" style="font-size: 16px; font-weight: bold;" id="feedbackQuestion">
                        <!-- Question will be dynamically updated based on user level -->
                    </p>
                    <div class="form-group mb-3" id="feedbackInputContainer" style="display: none;">
                        <textarea id="feedbackCommentInput" class="form-control" placeholder="Enter your opinion (optional)" rows="2"></textarea>
                    </div>
                    <div id="feedbackButtonContainer">
                        <button id="feedbackYesBtn" class="btn btn-success mx-2">👍 Yes</button>
                        <button id="feedbackNoBtn" class="btn btn-danger mx-2">👎 No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penjelasan with dynamic content structure -->
<div class="modal fade" id="explanationModal" tabindex="-1" role="dialog" aria-labelledby="explanationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="explanationModalLabel">Conversion Explanation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modalExplanationContent" class="explanation-text">
          <!-- Content will be populated dynamically based on the response format -->
          <div class="text-center">
            <p>Explanation is loading, please wait...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Level Selection -->
<div class="modal fade" id="levelSelectionModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="levelSelectionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="levelSelectionModalLabel">Select Python Knowledge Level</h5>
      </div>
      <div class="modal-body text-center">
      <p style="font-size: 16px;">How familiar are you with Python programming?</p>
        <div class="row mt-4">
          <div class="col-md-6">
            <button id="beginnerLevelBtn" class="btn btn-info btn-block py-3">
              <i class="fas fa-graduation-cap mb-2" style="font-size: 24px;"></i><br>
              I'm still learning<br>
              <small>(Learning Mode)</small>
            </button>
          </div>
          <div class="col-md-6">
            <button id="expertLevelBtn" class="btn btn-primary btn-block py-3">
              <i class="fas fa-code mb-2" style="font-size: 24px;"></i><br>
              I'm experienced<br>
              <small>(Professional Mode)</small>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast Container for Notifications -->
<div class="toast-container">
  <div id="saveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <i id="toastIcon" class="fas fa-check-circle mr-2 text-success"></i>
      <strong id="toastTitle">Success</strong>
      <small id="toastTime" style="display: none;">Just now</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" style="display: none;">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body" id="toastMessage">
      Conversion saved successfully!
    </div>
  </div>
</div>

<!-- Include CodeMirror library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/python/python.min.js"></script>
<!-- Skulpt for Python execution in browser -->
<script src="https://skulpt.org/js/skulpt.min.js" type="text/javascript"></script>
<script src="https://skulpt.org/js/skulpt-stdlib.js" type="text/javascript"></script>

<!-- CSRF Token & Route for JS -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.syntaxConverterConvertRoute = "{{ route('syntax-converter.convert') }}";
    window.syntaxConverterShowUrl = "{{ url('syntax-converter') }}/:id";
    window.syntaxConverterFeedbackRoute = "{{ route('syntax-converter.feedback') }}";
    window.userEmail = "{{ Auth::user()->email }}";
    window.userName = "{{ Auth::user()->name }}";
</script>

<!-- External CSS and JS -->
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<script src="{{ asset('js/user.js') }}"></script>

<!-- Tambahkan Bootstrap JS jika belum ada -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

@endsection