@extends('layouts.front')
@section('title')
    My Report
@endsection

@section('content')
    <!-- Report Header -->
    <div class="section-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title">My Learning Report</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></div>
            <div class="breadcrumb-item active">Learning Report</div>
        </div>
    </div>

    <!-- Performance Overview Cards -->
    <!-- Summary Stats Card -->
    <div class="card mb-4 summary-card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div class="achievement-badge me-3">
                            <img src="/image_upload/{{ $current_badge['file'] }}" alt="{{ $current_badge->name }}"
                                class="badge-image">
                        </div>
                        <div>
                            <span class="text-muted d-block">Current Badge</span>
                            <h4 class="mb-0">{{ $current_badge->name }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-item">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block">Total Score</span>
                            <h2 class="mb-0">{{ $final_score }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-item">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block">Overall Progress</span>
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0 me-2">{{ $percentage }}%</h2>
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: {{ $percentage }}%;"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stat-item">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-code"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block">Tests Completed</span>
                            <h2 class="mb-0">{{ sizeof($finish_code_tests) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skills Radar Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Skills Overview</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="skillsRadarChart" style="height: 250px;"></canvas>
                        </div>
                        <div class="col-md-4">
                            <div class="legend-item mb-3">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-book text-info"></i> Reading</span>
                                    <span
                                        class="badge badge-info">{{ $code_score->sum(function ($sc) {
                                            $c = \App\Models\Content::find($sc->content_id);
                                            return \App\Models\WonderingScore::where(['user_id' => Auth::id()])->where('content_id', $c->id)->sum('score');
                                        }) }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-info" style="width: 75%;"></div>
                                </div>
                            </div>
                            <div class="legend-item mb-3">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-code text-success"></i> Coding</span>
                                    <span class="badge badge-success">{{ $code_score->sum('score') }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-success" style="width: 80%;"></div>
                                </div>
                            </div>
                            <div class="legend-item mb-3">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-edit text-primary"></i> Essays</span>
                                    <span
                                        class="badge badge-primary">{{ $code_score->sum(function ($sc) {
                                            $q = \App\Models\Question::find($sc->question_id);
                                            $c = \App\Models\Content::find($sc->content_id);
                                            $wondering = \App\Models\WonderingScore::where(['user_id' => Auth::id()])->where('content_id', $c->id)->sum('score');
                                            $exploring = \App\Models\UserScore::where('user_id', Auth::id())->where('question_id', $q->id)->sum('score');
                                            $score = \App\Models\TotalScore::where('user_id', Auth::id())->where('question_id', $q->id)->sum('score');
                                            return $score != 0 ? $score - ($wondering + $exploring) : 0;
                                        }) }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-primary" style="width: 65%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Code Test Report -->
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-code-branch mr-2"></i> Code Test Reports</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th class="text-center">Success</th>
                            <th class="text-center">Errors</th>
                            <th>Reading Score</th>
                            <th>Coding Score</th>
                            <th>Essay Score</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($code_score as $sc)
                            @php
                                $q = \App\Models\Question::find($sc->question_id);
                                $c = \App\Models\Content::find($sc->content_id);
                                $wondering = \App\Models\WonderingScore::where(['user_id' => Auth::id()])
                                    ->where('content_id', $c->id)
                                    ->sum('score');
                                $exploring = \App\Models\UserScore::where('user_id', Auth::id())
                                    ->where('question_id', $q->id)
                                    ->sum('score');
                                $score = \App\Models\TotalScore::where('user_id', Auth::id())
                                    ->where('question_id', $q->id)
                                    ->sum('score');

                                $explain = 0;
                                if ($score != 0) {
                                    $explain = $score - ($wondering + $exploring);
                                }

                                $err = \App\Models\ExerciseCodeLog::where([
                                    'user_id' => Auth::id(),
                                    'question_id' => $sc->question_id,
                                    'is_error' => 1,
                                ])->count();

                                $success = \App\Models\ExerciseCodeLog::where([
                                    'user_id' => Auth::id(),
                                    'question_id' => $sc->question_id,
                                    'is_error' => 0,
                                ])->count();

                                $total = $wondering + $sc->score + $explain;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="question-icon mr-3">
                                            <i class="fas fa-puzzle-piece text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $q->question_name }}</h6>
                                            <small
                                                class="text-muted">{{ Str::limit($q->content_id ? \App\Models\Content::find($q->content_id)->content_name : '', 30) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success badge-pill">{{ $success }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-danger badge-pill">{{ $err }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 mr-2" style="height: 6px;">
                                            <div class="progress-bar bg-info"
                                                style="width: {{ min(100, ($wondering / 10) * 100) }}%;"></div>
                                        </div>
                                        <span>{{ $wondering }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 mr-2" style="height: 6px;">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ min(100, ($sc->score / 30) * 100) }}%;"></div>
                                        </div>
                                        <span>{{ $sc->score }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 mr-2" style="height: 6px;">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ min(100, ($explain / 10) * 100) }}%;"></div>
                                        </div>
                                        <span>{{ $explain }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-light font-weight-bold">{{ $total }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('student_course.report.detail', ['question_id' => $sc->question_id]) }}"
                                        class="btn btn-sm btn-primary" data-toggle="tooltip"
                                        title="View detailed report">
                                        <i class="fa fa-info-circle"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        body {
            background-color: #f4f7fa;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #344767;
            margin-bottom: 0;
        }

        /* Summary Card */
        .summary-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        /* Achievement Badge */
        .achievement-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            padding: 4px;
        }

        .badge-image {
            max-width: 50px;
            max-height: 50px;
        }

        /* Stats Items */
        .stat-item {
            display: flex;
            align-items: center;
        }

        .stat-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            margin-right: 1rem;
            color: #fff;
        }

        .stat-icon i {
            font-size: 1.5rem;
        }

        /* Skills */
        .skill-item {
            padding: 0.5rem 0;
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: #344767;
            border-top: none;
            background-color: rgba(248, 249, 250, 0.5);
        }

        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table tr:hover {
            background-color: rgba(248, 249, 250, 0.5);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .badge.rounded-pill {
            padding-right: 0.6em;
            padding-left: 0.6em;
        }

        /* Button groups */
        .btn-group .btn {
            border-radius: 0.25rem;
            margin: 0 0.125rem;
        }

        /* Responsiveness */
        @media (max-width: 992px) {
            .stat-item {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }

        .card-achievement {
            background: linear-gradient(120deg, #f6f7f9, #ffffff);
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-achievement:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
        }

        .achievement-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            padding: 5px;
        }

        .badge-image {
            max-width: 80px;
            max-height: 80px;
        }

        .badge-pill {
            padding-right: 1em;
            padding-left: 1em;
            border-radius: 10rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .legend-item {
            padding: 0.5rem 0;
        }
    </style>

    <!-- Scripts for Charts -->
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Radar chart for skills overview
            const ctx = document.getElementById('skillsRadarChart').getContext('2d');

            // Calculate averages for each skill category
            const readingAvg =
                {{ $code_score->avg(function ($sc) {
                    $c = \App\Models\Content::find($sc->content_id);
                    return \App\Models\WonderingScore::where(['user_id' => Auth::id()])->where('content_id', $c->id)->sum('score');
                }) ?? 0 }};

            const codingAvg = {{ $code_score->avg('score') ?? 0 }};

            const essayAvg =
                {{ $code_score->avg(function ($sc) {
                    $q = \App\Models\Question::find($sc->question_id);
                    $c = \App\Models\Content::find($sc->content_id);
                    $wondering = \App\Models\WonderingScore::where(['user_id' => Auth::id()])->where('content_id', $c->id)->sum('score');
                    $exploring = \App\Models\UserScore::where('user_id', Auth::id())->where('question_id', $q->id)->sum('score');
                    $score = \App\Models\TotalScore::where('user_id', Auth::id())->where('question_id', $q->id)->sum('score');
                    return $score != 0 ? $score - ($wondering + $exploring) : 0;
                }) ?? 0 }};

            const errorsAvg =
                {{ $code_score->avg(function ($sc) {
                    return \App\Models\ExerciseCodeLog::where([
                        'user_id' => Auth::id(),
                        'question_id' => $sc->question_id,
                        'is_error' => 1,
                    ])->count();
                }) ?? 0 }};

            const successAvg =
                {{ $code_score->avg(function ($sc) {
                    return \App\Models\ExerciseCodeLog::where([
                        'user_id' => Auth::id(),
                        'question_id' => $sc->question_id,
                        'is_error' => 0,
                    ])->count();
                }) ?? 0 }};

            // Create chart
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: [
                        'Reading Comprehension',
                        'Coding Skills',
                        'Essay Writing',
                        'Error Handling',
                        'Test Success Rate'
                    ],
                    datasets: [{
                        label: 'Your Skills',
                        data: [
                            readingAvg * 10, // Scale appropriately
                            codingAvg * 3.33, // Scale to 100
                            essayAvg * 10,
                            Math.max(0, 100 - (errorsAvg *
                                10)), // Inverse of errors (fewer is better)
                            successAvg * 10
                        ],
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        pointBackgroundColor: 'rgb(54, 162, 235)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(54, 162, 235)'
                    }]
                },
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    }
                }
            });
        });
    </script>
@endsection
@endsection
