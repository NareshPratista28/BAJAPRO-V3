<!-- filepath: c:\Projects\Skripsi\BAJAPRO-V3\resources\views\admin\history\index.blade.php -->
@extends('layouts.app')

@section('title')
    LLM Generation Logs
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">LLM Generation Logs</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="card-title">Generation History</h5>
                                <form action="{{ route('admin.history.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Search by topic..." value="{{ $search ?? '' }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if (count($histories) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>ID</th>
                                                <th>Content</th>
                                                <th>Topic</th>
                                                <th>Generation Time</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($histories as $history)
                                                <tr>
                                                    <td>{{ $history['id'] }}</td>
                                                    <td>
                                                        @if (isset($history['content_id']))
                                                            <a
                                                                href="{{ route('admin.contents.show', $history['content_id']) }}">
                                                                Content #{{ $history['content_id'] }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $history['topic_title'] ?? 'N/A' }}</td>
                                                    <td>{{ number_format($history['generation_time'] ?? 0, 2) }}s</td>
                                                    <td>{{ date('Y-m-d H:i:s', strtotime($history['created_at'] ?? 'now')) }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.history.show', $history['id']) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-info mx-2"></i>Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $histories->links() }}
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h2>No Generation Logs Found</h2>
                                    <p class="lead">
                                        There are no LLM generation logs recorded yet.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
