<style>
  #logo {
    font-size : 2rem;
    font-weight : 700;
    color : #6777EF;
  }
</style>

<nav class="navbar navbar-secondary navbar-expand-lg navbar-light" style="background: #ffffff; left:0">
  <div class="container">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a href="/" id="logo" class="nav-link has-dropdown">
          <img src="{{ asset('img/logo-kecil.png') }}" alt="logo" width="230">
        </a>
      </li>
      {{--<li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-heart"></i> <span>Courses</span></a>
      </li>--}}
      <li class="nav-item mt-1">
        <a href="{{ route('student_course.my_course') }}" class="nav-link "><i class="far fa-clone"></i> <span>My
            Course</span></a>
      </li>

      <li class="nav-item mt-1">
        <a href="{{ route('student_course.report') }}" class="nav-link "><i class="far fa-clone"></i> <span>My
            Report</span></a>
      </li>

      {{--<li class="nav-item">
        <a href="{{ route('student_course.show.explain') }}" class="nav-link "> 
        <span>
        <i class='far fa-file-alt' style='font-size:18px'></i>
        </span>Summary Explanation</a>
      </li>--}}

      <li class="nav-item mt-1">
        <a href="{{ route('student_course.show.explain.code') }}" class="nav-link "><i class="far fa-file-code"  style='font-size:18px'></i>
        <span>Explanation</span></a>
      </li>

      <li class="nav-item mt-1">
        <a href="{{ route('student_course.leaderboard') }}" class="nav-link "><i class="fa fa-signal" style='font-size:18px'></i>
        <span>Leaderboard</span></a>
      </li>

    </ul>
    <div class="d-flex">
      <ul class="navbar-nav">
        @auth
          <li class="nav-item dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
              <i class="far fa-user-circle"></i>
              <span>{{ \Illuminate\Support\Facades\Auth::user()->email }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="nav-link" href="">Total Score: <b>{{ \App\Models\UserScore::getScore() }}</b></a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              @if (\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                <li class="nav-item">
                  {{--<a href="{{ route('admin.dashboard') }}" class="nav-link">Goto Admin</a>--}}
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
