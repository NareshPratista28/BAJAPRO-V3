<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
  <a class="nav-link" href="/admin">
    <i class=" fas fa-building"></i><span>Leaderboard</span>
  </a>
</li>
<li class="{{ Request::is('roles*') ? 'active' : '' }}">
  <a href="{{ route('admin.roles.index') }}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>

<li class="{{ Request::is('courses*') ? 'active' : '' }}">
  <a href="{{ route('admin.courses.index') }}"><i class="fa fa-book"></i><span>Courses</span></a>
</li>

<li class="{{ Request::is('level*') ? 'active' : '' }}">
  <a href="{{ route('admin.level.index') }}"><i class="fa fa-signal"></i><span>Level</span></a>
</li>

{{--<li class="{{ Request::is('explaination*') ? 'active' : '' }}">
  <a href="{{ route('admin.explaination.index') }}"><i class="fa fa-tasks"></i><span>Summary Explanation</span></a>
</li>--}}

<li class="{{ Request::is('explaination*') ? 'active' : '' }}">
  <a href="{{ route('admin.code.index.explanation') }}"><i class="far fa-file-code"  style='font-size:18px'></i><span>Explanation</span></a>
</li>

<li class="{{ Request::is('lessons*') ? 'active' : '' }}">
  <a href="{{ route('admin.lessons.index') }}"><i class="fa fa-book-open"></i><span>Lessons</span></a>
</li>
<li class="{{ Request::is('contents*') ? 'active' : '' }}">
  <a href="{{ route('admin.contents.index') }}"><i class="fa fa-list-ul"></i><span>Contents</span></a>
</li>
<li class="{{ Request::is('questions*') ? 'active' : '' }}">
  <a href="{{ route('admin.questions.index') }}"><i class="fa fa-question-circle"></i><span>Questions</span></a>
</li>
<li class="{{ Request::is('questions*') ? 'active' : '' }}">
  <a href="{{ route('admin.users.index') }}"><i class="fa fa-user-circle"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('report*') ? 'active' : '' }}">
  <a href="{{ route('admin.dashboard.report') }}"><i class="fa fa-user-circle"></i><span>Report</span></a>
</li>

<li class="{{ Request::is('badgeSettings*') ? 'active' : '' }}">
  <a href="{{ route('admin.badgeSettings.index') }}"><i class="fa fa-medal"></i><span>Badge Settings</span></a>
</li>
