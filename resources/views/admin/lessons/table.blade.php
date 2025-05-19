<div class="table-responsive">
    <table class="table table-hover table-striped" id="lessons-table">
        <thead>
            <tr class="bg-light">
                <th style="width: 20%" class="text-center">Title</th>
                <th style="width: 20%" class="text-center">Description</th>
                <th style="width: 10%" class="text-center">Published</th>
                <th style="width: 15%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
                <tr>
                    <td>
                        <div class="font-weight-bold">{{ $lesson->title }}</div>
                    </td>
                    <td>
                        <div class="question-preview">
                            {{ Str::limit($lesson->description, 100) }}
                        </div>
                    </td>
                    <td class="text-center">
                        @if ($lesson->published)
                            <span class="badge badge-success badge-pill px-3 py-2">Published</span>
                        @else
                            <span class="badge badge-warning badge-pill px-3 py-2">Draft</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open([
                            'route' => ['admin.lessons.destroy', $lesson->id],
                            'method' => 'delete',
                            'class' => 'd-inline',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{!! route('admin.lessons.show', [$lesson->id]) !!}" class='btn btn-sm btn-light' data-toggle="tooltip"
                                title="View Lesson">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{!! route('admin.lessons.edit', [$lesson->id]) !!}" class='btn btn-sm btn-info' data-toggle="tooltip"
                                title="Edit Lesson">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="submit" class='btn btn-sm btn-danger'
                                onclick="return confirm('Are you sure you want to delete this lesson?')"
                                data-toggle="tooltip" title="Delete Lesson">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

            @if (count($lessons) === 0)
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h2>No Lessons Found</h2>
                            <p class="lead">
                                Start by adding lessons to your course.
                            </p>
                            <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary mt-4">
                                <i class="fas fa-plus mr-1"></i> Add Lesson
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

    .table td {
        vertical-align: middle;
        padding: 15px;
        border-color: #f1f1f1;
    }

    /* Description preview */
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
