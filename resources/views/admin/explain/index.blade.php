@extends('layouts.app')
@section('title')
  Explanation
@endsection
@section('content')
  <section class="section">
    <div class="section-header">
    @if($title == "summary")
        <h1>Summary Explanation</h1>
    @else
        <h1>Code Explanation</h1>
    @endif
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">
          @include('admin.explain.table_essay')
        </div>
      </div>
    </div>
    @include('stisla-templates::common.paginate', ['records' => $explain])

  </section>
@endsection
