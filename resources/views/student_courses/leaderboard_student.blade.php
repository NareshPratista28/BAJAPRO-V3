@extends('layouts.front')
@section('content')

<div class="section-body pb-2">

    <h2 class="section-title">Leaderboard</h2>
    <p class="section-lead">
        In this page, you will see your position<br />

    </p>
<!-- Your content goes here -->
</div>
<div class="row">
    <div class="col-md-12">
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
</div>
@endsection