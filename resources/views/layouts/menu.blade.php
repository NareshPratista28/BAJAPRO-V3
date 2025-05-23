<!-- Dashboard -->
<li class="menu-header">Dashboard</li>
<li class="side-menus {{ Request::is('admin') ? 'active' : '' }}">
    <a class="nav-link" href="/admin">
        <i class="fas fa-tachometer-alt"></i>
        <span>Leaderboard</span>
    </a>
</li>

<!-- Course Management -->
<li class="menu-header">Course Management</li>
<li class="{{ Request::is('admin/courses*') ? 'active' : '' }}">
    <a href="{{ route('admin.courses.index') }}">
        <i class="fa fa-book"></i>
        <span>Courses</span>
    </a>
</li>
<li class="{{ Request::is('admin/level*') ? 'active' : '' }}">
    <a href="{{ route('admin.level.index') }}">
        <i class="fa fa-layer-group"></i>
        <span>Levels</span>
    </a>
</li>
<li class="{{ Request::is('admin/lessons*') ? 'active' : '' }}">
    <a href="{{ route('admin.lessons.index') }}">
        <i class="fa fa-book-open"></i>
        <span>Lessons</span>
    </a>
</li>
<li class="{{ Request::is('admin/contents*') ? 'active' : '' }}">
    <a href="{{ route('admin.contents.index') }}">
        <i class="fa fa-file-alt"></i>
        <span>Contents</span>
    </a>
</li>

<!-- Learning Materials -->
<li class="menu-header">Learning Materials</li>
<li class="{{ Request::is('admin/questions*') ? 'active' : '' }}">
    <a href="{{ route('admin.questions.index') }}">
        <i class="fa fa-question-circle"></i>
        <span>Questions</span>
    </a>
</li>
<li class="{{ Request::is('admin/code*') ? 'active' : '' }}">
    <a href="{{ route('admin.code.index.explanation') }}">
        <i class="far fa-file-code"></i>
        <span>Code Explanations</span>
    </a>
</li>

<!-- System Management -->
<li class="menu-header">System Management</li>
<li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
    <a href="{{ route('admin.users.index') }}">
        <i class="fa fa-users"></i>
        <span>Users</span>
    </a>
</li>
<li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
    <a href="{{ route('admin.roles.index') }}">
        <i class="fa fa-user-tag"></i>
        <span>Roles</span>
    </a>
</li>
<li class="{{ Request::is('admin/badgeSettings*') ? 'active' : '' }}">
    <a href="{{ route('admin.badgeSettings.index') }}">
        <i class="fa fa-medal"></i>
        <span>Badge Settings</span>
    </a>
</li>

<!-- Reports -->
<li class="menu-header">Analytics</li>
<li class="{{ Request::is('admin/report*') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard.report') }}">
        <i class="fa fa-chart-bar"></i>
        <span>Reports</span>
    </a>
</li>
<li class="{{ Request::is('admin/history*') ? 'active' : '' }}">
    <a href="{{ route('admin.history.index') }}">
        <i class="fa fa-history"></i>
        <span>LLM Generation Logs</span>
    </a>
</li>
