<!-- filepath: c:\Projects\Skripsi\BAJAPRO-V3\resources\views\admin\history\content.blade.php -->
@extends('layouts.app')

@section('title')
    History for {{ $content->title }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">LLM Generation History for "{{ $content->title }}"</h3>
            <div class="section-header-breadcrumb">
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if (count($histories) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
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
                                                    <td>{{ $history['topic_title'] ?? 'N/A' }}</td>
                                                    <td>{{ number_format($history['generation_time'] ?? 0, 2) }}s</td>
                                                    <td>{{ date('Y-m-d H:i:s', strtotime($history['created_at'] ?? 'now')) }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.history.show', $history['id']) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i> Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h2>No History Found</h2>
                                    <p class="lead">
                                        There are no LLM generations recorded for this content yet.
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
