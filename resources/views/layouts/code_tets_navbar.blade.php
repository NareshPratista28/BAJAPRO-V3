<!-- filepath: c:\Projects\Skripsi\BAJAPRO-V3\resources\views\layouts\code_tets_navbar.blade.php -->
<nav class="navbar navbar-secondary fixed-top navbar-expand-lg"
    style="background: #ffffff; left:0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 10px 0;">
    <div class="container-fluid">
        <div class="d-flex align-items-center navbar-brand-section">
            <a href="{{ route('student_course.my_course') }}" class="navbar-brand mr-3">
                <img src="{{ asset('img/1.png') }}" alt="logo" height="40">
            </a>
            <span class="badge badge-light p-2 code-challenge-badge">
                <i class="fas fa-code mr-1"></i> Code Challenge
            </span>
        </div>

        <div class="d-flex align-items-center mx-auto code-controls">
            <button id="run-btn" onclick="runCode()" class="btn btn-primary mr-3">
                <i class="fa fa-play mr-1"></i> Run Code
            </button>

            <form class="d-flex align-items-center m-0">
                @csrf
                <input type="hidden" value="{{ \Illuminate\Support\Facades\Auth::id() }}" name="user_id"
                    id="user_id">
                <input type="hidden" value="{{ $question->id }}" name="question_id" id="question_id">
                <input type="hidden" value="{{ request()->get('content_id') }}" name="content_id" id="content_id">
                <input type="hidden" value="{{ request()->get('course_id') }}" name="course_id" id="course_id">
                <input type="hidden" value="{{ request()->get('level_id') }}" name="level_id" id="level_id">
                <input type="hidden" value="0" name="score" id="score">

                <button type="button" class="btn btn-success" data-toggle="modal" id="submit_code">
                    <i class="fa fa-save mr-1"></i> Submit
                </button>
            </form>
        </div>

        <div class="d-flex align-items-center">
            @auth
                <div class="dropdown user-dropdown">
                    <a href="#" data-toggle="dropdown"
                        class="nav-link dropdown-toggle user-link d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="far fa-user-circle mr-1"></i>
                            <span class="d-none d-md-block">{{ \Illuminate\Support\Facades\Auth::user()->email }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown-menu">
                        <div class="dropdown-header d-flex align-items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            <h6 class="mb-0">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('student_course.my_course') }}">
                            <i class="fas fa-book-open mr-2"></i> My Courses
                        </a>
                        <a class="dropdown-item" href="{{ route('student_course.report') }}">
                            <i class="fas fa-chart-bar mr-2"></i> My Reports
                        </a>
                        @if (\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                            <a href="{{ route('admin.leaderboard') }}" class="dropdown-item">
                                <i class="fas fa-crown mr-2"></i> Admin Panel
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <div class="px-3 py-2">
                            {!! Form::open(['route' => 'logout', 'method' => 'POST']) !!}
                            @csrf
                            <button
                                class="btn btn-danger btn-sm btn-block d-flex align-items-center justify-content-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    .navbar.navbar-secondary {
        height: 70px;
        transition: all 0.3s ease;
    }

    .navbar-brand-section {
        min-width: 200px;
    }

    .code-challenge-badge {
        font-weight: 500;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }

    .code-controls {
        max-width: 500px;
    }

    .btn-primary {
        background-color: #4a6cf7;
        border-color: #4a6cf7;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #3a5ce5;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(74, 108, 247, 0.2);
    }

    .btn-success {
        background-color: #38c172;
        border-color: #38c172;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-success:hover {
        background-color: #2fa360;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(56, 193, 114, 0.2);
    }

    .user-dropdown .dropdown-toggle::after {
        display: none;
    }

    .user-link {
        padding: 6px 10px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .user-link:hover {
        background-color: #f8f9fa;
    }

    .user-score .badge {
        font-size: 13px;
    }

    .user-dropdown-menu {
        min-width: 240px;
        padding: 8px 0;
        margin-top: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 6px;
    }

    .dropdown-header {
        background-color: #f8f9fa;
        padding: 12px 16px;
    }

    .dropdown-item {
        padding: 10px 16px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f1f5ff;
    }

    .btn-danger {
        background-color: #ff5e5e;
        border-color: #ff5e5e;
        transition: all 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #e74a4a;
        border-color: #e74a4a;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .code-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .code-controls button,
        .code-controls form {
            margin: 5px 0;
            width: 100%;
        }

    }

    @keyframes pulse {
        0% {
            opacity: 0.8;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.8;
        }
    }
</style>
