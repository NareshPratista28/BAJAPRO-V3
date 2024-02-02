@extends('layouts.app')
@section('title')
    Leaderboard
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Leaderboard</h1>
            
        </div>
    <div class="section-body">
       <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="leaderboard-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Badge Name</th>
                                <th>Badge</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            @php
                                $class = '';
                                if($item['user']->class == 1){
                                    $class = 'MI PSDKU PAMEKASAN';
                                }else if($item['user']->class == 2){
                                    $class = 'SIB POLINEMA PUSAT';
                                }
                            @endphp
                            <tr>
                                    <td>{{  $loop->iteration }}</td>
                                    <td>{{ $item['current_badge']->name }}</td>
                                    <td>
                                        <img src="/image_upload/{{ $item['current_badge']->file }}" width="50px">
                                    </td>
                                    <td>{{ $item['user']->name }}</td>
                                    <td>{{ $class }}</td>
                                    <td>{{ $item['final_score'] }}</td>
                                    
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
    </div>

        {{--@include('stisla-templates::common.paginate', ['records' => $data])--}}

    </section>
@endsection
