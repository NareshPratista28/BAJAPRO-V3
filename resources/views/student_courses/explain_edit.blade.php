@extends('layouts.front')
@section('content')
<div class="section-body pb-2">
    <h2 class="section-title">Explanation</h2>
    <p class="section-lead">
        In this page, you will be able to read the explanation of level from another user<br />

    </p>
    <!-- Your content goes here -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('student_course.update.explain', [$explain->id, $title]) }}" id="myForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                        @include('student_courses.explain_field')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection