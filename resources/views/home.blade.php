@extends('layouts.front')
@section('title')
    Home
@endsection

@section('content')
    @if (Session::has('msg_error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('msg_error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (Session::has('msg_error1'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('msg_error1') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Available Courses Section -->
    <section class="section" id="available-courses">
        <div class="section-body">
            <h2 class="section-title">Available Courses</h2>
            <p class="section-lead">
                Discover our collection of Java programming courses and start learning today.
            </p>
        </div>

        <div class="row mt-4">
            @foreach ($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-card">
                        <!-- Course Header -->
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">{{ $course->course_name }}</h4>
                        </div>

                        <!-- Course Content -->
                        <div class="card-body">
                            <div class="mb-3">
                                {{ substr($course->description, 0, 120) }}{{ strlen($course->description) > 120 ? '...' : '' }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary text-white py-2 px-3 rounded-pill">
                                    <i class="fa fa-book mr-1"></i> {{ $course->lessons->count() }} Lessons
                                </span>
                                <span class="badge bg-secondary text-white py-2 px-3 rounded-pill">
                                    <i class="fa fa-users mr-1"></i> {{ $course->student_courses->count() }} Students
                                </span>
                            </div>
                        </div>

                        <!-- Course Actions -->
                        <div class="card-footer bg-white border-0 pt-0">
                            <div class="row">
                                <div class="col-6 pr-1">
                                    <a href="{{ route('student_course.detail', [$course->id]) }}"
                                        class="btn btn-outline-secondary btn-block">
                                        <i class="fa fa-info-circle mr-1"></i> Details
                                    </a>
                                </div>
                                @if (!in_array($course->id, $take_ids))
                                    <div class="col-6 pl-1">
                                        {!! Form::open(['route' => 'student_course.take', 'method' => 'POST']) !!}
                                        @csrf
                                        {!! Form::hidden('course_id', $course->id) !!}
                                        <button class="btn btn-primary btn-block">
                                            <i class="fa fa-plus mr-1"></i> Enroll
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                @else
                                    <div class="col-6 pl-1">
                                        <button class="btn btn-success btn-block" disabled>
                                            <i class="fa fa-check mr-1"></i> Enrolled
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Add custom styles -->
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
