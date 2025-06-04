@extends('layouts.front')

@section('content')
<div class="section-body">
    <h2 class="section-title">Syntax Conversion History</h2>
    <p class="section-lead">
        List of all syntax conversions you have performed.
    </p>
    
    <div class="card">
        <div class="card-header">
            <h4>Conversion History</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conversions as $conversion)
                        <tr>
                            <td>{{ $conversion->title }}</td>
                            <td>{{ $conversion->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('syntax-converter.index', ['id' => $conversion->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('syntax-converter.delete', $conversion->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $conversion->id }}" data-title="{{ $conversion->title }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No conversion history yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('syntax-converter.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Conversion
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach click handlers to all delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Delete Confirmation',
                    html: `Are you sure you want to delete the conversion <strong>"${title}"</strong>?<br><br>Deleted data cannot be recovered.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if confirmed
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
