@extends('layouts.front')
@section('title')
    My Course
@endsection

@section('content')
    <!-- My Courses Header -->
    <div class="section-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="section-title mb-2">My Course</h1>
                <p class="section-lead mb-0">
                    In this page, you will see your enrolled courses
                </p>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></div>
                <div class="breadcrumb-item active">My Course</div>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Enrolled Courses</h4>
                    </div>
                    <div class="card-body">
                        {{ $studentCourses->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Completed Lessons</h4>
                    </div>
                    <div class="card-body">
                        <!-- Calculate completed lessons count -->
                        {{ $studentCourses->sum(function ($course) {
                            return $course->completed_lessons_count ?? 0;
                        }) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>In Progress</h4>
                    </div>
                    <div class="card-body">
                        <!-- Calculate in-progress courses -->
                        {{ $studentCourses->where('completion_percentage', '<', 100)->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Achievements</h4>
                    </div>
                    <div class="card-body">
                        <!-- Calculate achievements or certificates -->
                        {{ $studentCourses->where('completion_percentage', '>=', 100)->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="section-body">
            <h2 class="section-title">Continue Your Learning</h2>
            <p class="section-lead">
                Pick up where you left off or explore your enrolled courses.
            </p>
        </div>

        <div class="row mt-4">
            @if ($studentCourses->count() > 0)
                @foreach ($studentCourses as $course)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 position-relative">
                            <!-- Progress Indicator -->
                            <div class="progress position-absolute"
                                style="height: 4px; top: 0; left: 0; right: 0; border-radius: 3px 3px 0 0;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $course->completion_percentage ?? 0 }}%"></div>
                            </div>

                            <!-- Course Header -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>{{ $course->course_name }}</h4>
                                <span
                                    class="badge badge-{{ (($course->completion_percentage ?? 0) >= 100
                                            ? 'success'
                                            : ($course->completion_percentage ?? 0) > 0)
                                        ? 'info'
                                        : 'light' }}">
                                    {{ (($course->completion_percentage ?? 0) >= 100
                                            ? 'Completed'
                                            : ($course->completion_percentage ?? 0) > 0)
                                        ? 'In Progress'
                                        : 'Not Started' }}
                                </span>
                            </div>

                            <!-- Course Content -->
                            <div class="card-body">
                                <p>{{ Str::limit($course->description, 100) }}</p>

                                <div class="d-flex justify-content-between mt-3">
                                    <span class="badge badge-primary p-2">
                                        <i class="fa fa-book mr-1"></i> {{ $course->lessons->count() }} Lessons
                                    </span>
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar-alt mr-1"></i> Last accessed:
                                        {{ isset($course->last_accessed) ? $course->last_accessed->diffForHumans() : 'Never' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-whitesmoke">
                                <a href="{{ route('student_course.level', $course->id) }}"
                                    class="btn btn-primary btn-block">
                                    <i class="fa fa-play-circle mr-1"></i>
                                    {{ ($course->completion_percentage ?? 0) > 0 ? 'Continue Learning' : 'Start Course' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h2>You haven't enrolled in any courses yet</h2>
                        <p class="lead">
                            Start your learning journey by enrolling in a course from the home page.
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-4">Browse Courses</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
