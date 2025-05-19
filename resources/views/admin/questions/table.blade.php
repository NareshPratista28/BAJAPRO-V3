<div class="table-responsive">
    <table class="table table-hover table-striped" id="questions-table">
        <thead>
            <tr class="bg-light">
                <th style="width: 20%" class="text-center">
                    Content
                </th>
                <th style="width: 20%" class="text-center">
                    Question Name
                </th>
                <th style="width: 40%" class="text-center">Question</th>
                <th style="width: 10%" class="text-center">
                    Score
                </th>
                <th style="width: 10%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="font-weight-bold">{{ $question->content->title }}</span>
                                <small
                                    class="d-block text-muted">{{ $question->content->lesson->title ?? 'No lesson' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="font-weight-medium">{{ $question->question_name }}</div>
                    </td>
                    <td>
                        <div class="question-preview">
                            {!! Str::limit(strip_tags($question->question), 100) !!}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-success badge-pill px-3 py-2">{{ $question->score }} pts</span>
                    </td>
                    <td class="text-center">
                        {!! Form::open([
                            'route' => ['admin.questions.destroy', $question->id],
                            'method' => 'delete',
                            'class' => 'd-inline',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.questions.show', [$question->id]) !!}" class='btn btn-sm btn-light' data-toggle="tooltip"
                                title="View Question">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{!! route('admin.questions.edit', [$question->id]) !!}" class='btn btn-sm btn-info' data-toggle="tooltip"
                                title="Edit Question">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="submit" class='btn btn-sm btn-danger'
                                onclick="return confirm('Are you sure you want to delete this question?')"
                                data-toggle="tooltip" title="Delete Question">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

            @if (count($questions) === 0)
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h2>No Questions Found</h2>
                            <p class="lead">
                                Start by adding questions to your content.
                            </p>
                            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary mt-4">
                                <i class="fas fa-plus mr-1"></i> Add Question
                            </a>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<style>
    /* Table improvements */
    .table {
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 12px 15px;
    }

    .table th.sortable {
        cursor: pointer;
    }

    .table th.sortable:hover {
        background-color: #e9ecef;
    }

    .table th.sort-asc i:before {
        content: "\f0de";
        /* fa-sort-up */
    }

    .table th.sort-desc i:before {
        content: "\f0dd";
        /* fa-sort-down */
    }

    .table th.sort-asc i,
    .table th.sort-desc i {
        color: #007bff !important;
    }

    .table td {
        vertical-align: middle;
        padding: 15px;
        border-color: #f1f1f1;
    }

    /* Question preview */
    .question-preview {
        max-height: 80px;
        overflow: hidden;
        position: relative;
        color: #6c757d;
    }

    .question-preview:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(transparent, white);
    }

    /* Badge improvements */
    .badge {
        font-weight: 500;
        border-radius: 4px;
    }

    .badge-pill {
        border-radius: 50px;
        font-weight: 600;
    }

    /* Button styling */
    .btn-group .btn {
        border-radius: 4px;
        margin: 0 2px;
    }

    /* Empty state styling */
    .empty-state {
        text-align: center;
        padding: 20px;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #cdd3d8;
        margin-bottom: 20px;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
