@extends('layouts.app')
@section('title')
  Edit Explanation
@endsection
@section('content')
  <section class="section">
    <div class="section-header">
      <h3 class="page__heading m-0">Edit Explanation</h3>
      <div class="filter-container section-header-breadcrumb row justify-content-md-end">
        <a href="{{ route('admin.explaination.index') }}" class="btn btn-primary">Back</a>
      </div>
    </div>
    <div class="content">
      @include('stisla-templates::common.errors')
      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body ">
              @if($title == "summary")
                {!! Form::model($explain, ['route' => ['admin.explaination.update', $explain->id], 'method' => 'patch']) !!}
              @else
                {!! Form::model($explain, ['route' => ['admin.code.update.explanation', $explain->id], 'method' => 'put']) !!}
              @endif
                <div class="row">
                  @include('admin.explain.field')
                </div>

                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
