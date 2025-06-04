<nav class="navbar navbar-secondary navbar-expand-lg navbar-light" style="background: #ffffff; left:0">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="/" id="logo" class="nav-link d-flex align-items-center">
                    <img src="{{ asset('img/1.png') }}" alt="logo" width="180
                    ">
                </a>
            </li>
            {{-- <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-heart"></i> <span>Courses</span></a>
      </li> --}}
            <li class="nav-item mt-1">
                <a href="{{ route('student_course.my_course') }}" class="nav-link d-flex align-items-center"><i
                        class="far fa-clone"></i>
                    <span class="ml-2">My
                        Course</span></a>
            </li>

            <li class="nav-item mt-1">
                <a href="{{ route('student_course.report') }}" class="nav-link d-flex align-items-center "><i
                        class="far fa-clone"></i> <span class="ml-2">My
                        Report</span></a>
            </li>

            {{-- <li class="nav-item">
        <a href="{{ route('student_course.show.explain') }}" class="nav-link "> 
        <span>
        <i class='far fa-file-alt' style='font-size:18px'></i>
        </span>Summary Explanation</a>
      </li> --}}

            <li class="nav-item mt-1">
                <a href="{{ route('student_course.show.explain.code') }}" class="nav-link d-flex align-items-center "><i
                        class="far fa-file-code" style='font-size:18px'></i>
                    <span class="ml-2">Explanation</span></a>
            </li>

            <li class="nav-item mt-1">
                <a href="{{ route('student_course.leaderboard') }}" class="nav-link d-flex align-items-center "><i
                        class="fa fa-signal" style='font-size:18px'></i>
                    <span class="ml-2">Leaderboard</span></a>
            </li>
<li class="nav-item dropdown mt-1">
    <a href="#" class="nav-link d-flex align-items-center has-dropdown" data-toggle="dropdown">
        <i class="fa fa-tools" style="font-size:18px;"></i>
        <span class="ml-2">Tools</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('syntax-converter.index') }}" class="nav-link">Syntax Conversion</a>
        </li>
    </ul>
</li>

        </ul>
        <div class="d-flex">
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link d-flex align-items-center has-dropdown">
                            <i class="far fa-user-circle"></i>
                            <span class="ml-2">{{ \Illuminate\Support\Facades\Auth::user()->email }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                $wondering = \App\Models\WonderingScore::where(['user_id' => Auth::id()])->sum('score');
                                $exploring = \App\Models\UserScore::where('user_id', Auth::id())->sum('score');
                                $explainKonteks = \App\Models\ExplainingScore::where('user_id', Auth::id())->sum(
                                    'konteks_penjelasan',
                                );
                                $explainBenar = \App\Models\ExplainingScore::where('user_id', Auth::id())->sum(
                                    'kebenaran',
                                );
                                $explainKeruntutan = \App\Models\ExplainingScore::where('user_id', Auth::id())->sum(
                                    'keruntutan',
                                );
                                $final_score =
                                    $wondering + $exploring + $explainKonteks + $explainBenar + $explainKeruntutan;
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link" href="">Total Score:
                                    <b>{{ $final_score }}</b></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            @if (\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                                <li class="nav-item">
                                    {{-- <a href="{{ route('admin.dashboard') }}" class="nav-link">Goto Admin</a> --}}
                                    <a href="{{ route('admin.leaderboard') }}" class="nav-link">Goto Admin</a>
                                </li>
                            @endif
                            <br />
                            <li class="nav-item">
                                <div class="nav-link">
                                    {!! Form::open(['route' => 'logout', 'method' => 'POST']) !!}
                                    @csrf
                                    <button class="btn btn-danger btn-block">Logout <i class="fa fa-unlock"></i> </button>
                                    {!! Form::close() !!}
                                </div>

                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
