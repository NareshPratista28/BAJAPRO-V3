@extends('layouts.app')

@section('content')
<div class="section">
    <div class="section-header">
        <h3 class="page__heading">Rubrik Penilaian - {{$user->name}}</h3>
        <div class="filter-container section-header-breadcrumb row justify-content-md-end">
        <a href="{{ route('admin.dashboard.report',['user_id' => $user->id]) }}" class="btn btn-primary">Back</a>
      </div>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-title mx-2 my-5 border-bottom">
                <h4 class="text-center">{{$question->question_name}}</h4>
            </div>
            <form id="add-penilaian" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <h6> Wondering</h6>    
                        </div>
                        <div class="col-md-2">
                            <h6>:</h6>
                        </div>
                        <div class="col-md-5">
                            <p id="wondering_score">{{ $read->score ?? 0 }}</p>
                            <input type="hidden" id="iwondering_score" value="{{ $read->score ?? 0 }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <h6> Exploring</h6>    
                        </div>
                        <div class="col-md-2">
                            <h6>:</h6>
                        </div>
                        <div class="col-md-5">
                            <span id="exploring_score">{{ $coding->score ?? 0 }}</span>
                            <input type="hidden" id="iexploring_score" value="{{ $coding->score ?? 0 }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <h6> Explaining</h6>    
                        </div>
                        <div class="col-md-2">
                            <h6>:</h6>
                        </div>
                        <div class="col-md-5">
                            <span id="ttl_explain">
                            @if($explain_score->isNotEmpty())
                                {{$total}}
                            @else
                                0 
                            @endif
                        </span>
                        </div>
                    </div>
                    @foreach($answer as $index => $answers)
                        @if($index == 0)
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Pertanyaan</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->essay->question}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Jawaban User</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->answer}}
                                </div>
                            </div>
                            <div class="row mt-2 ml-4">
                                <div class="col-md-5">
                                    <span>Penjelasan sesuai konteks</span>    
                                </div>
                                <input type="hidden" id="essay_question_konteks" name="essay_question_konteks" value="{{$answers->essay->id}}">
                                <input type="hidden" id="user_answer_konteks" name="user_answer_konteks" value="{{$answers->id}}">
                                @if($explain_score->isNotEmpty())
                                        <div class="col-md-7">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks1" value="1" {{$konteks == '1' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="radioOption1">1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks2" value="2" {{$konteks == '2' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="radioOption2">2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks3" value="3" {{$konteks == '3' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="radioOption3">3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks4" value="4" {{$konteks == '4' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="radioOption2">4</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks5" value="5" {{$konteks == '5' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="radioOption3">5</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_konteks" value="{{$id_konteks}}">
                                @else
                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks1" value="1">
                                            <label class="form-check-label" for="radioOption1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks2" value="2">
                                            <label class="form-check-label" for="radioOption2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks3" value="3">
                                            <label class="form-check-label" for="radioOption3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks4" value="4">
                                            <label class="form-check-label" for="radioOption2">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio1" id="konteks5" value="5">
                                            <label class="form-check-label" for="radioOption3">5</label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @elseif($index == 1)
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Pertanyaan</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->essay->question}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Jawaban User</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->answer}}
                                </div>
                            </div>
                            @if($explain_score->isNotEmpty())
                                <div class="row mt-2 ml-4">
                                    <div class="col-md-5">
                                        <span>Keruntutan alur berpikir</span>    
                                    </div>
                                    <input type="hidden" id="essay_question_runtut" name="essay_question_runtut" value="{{$answers->essay->id}}">
                                    <input type="hidden" id="user_answer_runtut" name="user_answer_runtut" value="{{$answers->id}}">
                                    <input type="hidden" name="id_runtut" value="{{$id_runtut}}">
                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan1" value="1" {{$runtut == '1' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="radioOption1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan2" value="2" {{$runtut == '2' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="radioOption2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan3" value="3" {{$runtut == '3' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="radioOption3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan4" value="4" {{$runtut == '4' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="radioOption2">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan5" value="5" {{$runtut == '5' ? 'checked' : ''}}>
                                            <label class="form-check-label" for="radioOption3">5</label>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row mt-2 ml-4">
                                    <div class="col-md-5">
                                        <span>Keruntutan alur berpikir</span>    
                                    </div>
                                    <input type="hidden" id="essay_question_runtut" name="essay_question_runtut" value="{{$answers->essay->id}}">
                                    <input type="hidden" id="user_answer_runtut" name="user_answer_runtut" value="{{$answers->id}}">

                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan1" value="1">
                                            <label class="form-check-label" for="radioOption1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan2" value="2">
                                            <label class="form-check-label" for="radioOption2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan3" value="3">
                                            <label class="form-check-label" for="radioOption3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan4" value="4">
                                            <label class="form-check-label" for="radioOption2">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="exampleRadio2" id="keruntutan5" value="5">
                                            <label class="form-check-label" for="radioOption3">5</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif($index == 2)
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Pertanyaan</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->essay->question}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2">
                                    <span>Jawaban User</span>
                                </div>
                                <div class="col-md-1">
                                    <span>:</span>
                                </div>
                                <div class="col-md-8">
                                    {{$answers->answer}}
                                </div>
                            </div>
                            <div class="row mt-2 ml-4">
                            <div class="col-md-5">
                                <span>Kebenaran jawaban</span>    
                            </div>
                            <input type="hidden" id="essay_question_kebenaran" name="essay_question_kebenaran" value="{{$answers->essay->id}}">
                            <input type="hidden" id="user_answer_kebenaran" name="user_answer_kebenaran" value="{{$answers->id}}">
                            @if($explain_score->isNotEmpty())
                                <div class="col-md-7">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran1" value="1" {{$benar == '1' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioOption1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran2" value="2" {{$benar == '2' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioOption2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran3" value="3" {{$benar == '3' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioOption3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran4" value="4" {{$benar == '4' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioOption2">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran5" value="5" {{$benar == '5' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="radioOption3">5</label>
                                    </div>
                                </div>
                                <input type="hidden" name="id_benar" value="{{$id_benar}}">
                            @else
                                <div class="col-md-7">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran1" value="1">
                                        <label class="form-check-label" for="radioOption1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran2" value="2">
                                        <label class="form-check-label" for="radioOption2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran3" value="3">
                                        <label class="form-check-label" for="radioOption3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran4" value="4">
                                        <label class="form-check-label" for="radioOption2">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="exampleRadio3" id="kebenaran5" value="5">
                                        <label class="form-check-label" for="radioOption3">5</label>
                                    </div>
                                </div>
                            @endif
                    </div>
                        @endif
                    
                    
                    
                
                    
                    @endforeach

                    <div class="row mx-2 my-4 border-bottom border-3">

                    </div>
                    @if($explain_score->isNotEmpty())
                        <input type="hidden" name="ikonteks" id="ikonteks" value="{{$konteks}}">
                        <input type="hidden" name="iruntut" id="iruntut" value="{{$runtut}}">
                        <input type="hidden" name="ibenar" id="ibenar" value="{{$benar}}">
                        <input type="hidden" name="tot_score" id="tot_score" value="{{$explain_score->first()->total->score}}">
                        <input type="hidden" name="tot_explain" id="tot_explain" value="{{$total}}">
                    @else
                        <input type="hidden" name="ikonteks" id="ikonteks">
                        <input type="hidden" name="iruntut" id="iruntut">
                        <input type="hidden" name="ibenar" id="ibenar">
                        <input type="hidden" name="tot_score" id="tot_score">
                        <input type="hidden" name="tot_explain" id="tot_explain">
                    @endif
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                    <input type="hidden" name="question_id" id="question_id" value="{{$question->id}}">
                    <input type="hidden" name="content_id" id="content_id" value="{{$content->id}}">
                    <input type="hidden" name="wondering_id" id="wondering_id" value="{{$read->id}}">
                    <input type="hidden" name="exploring_id" id="exploring_id" value="{{$coding->id}}">

                    <div class="row mt-2">
                        <div class="col-md-5">
                            <h4>Total Score</h4>    
                        </div>
                        <div class="col-md-2">
                            <h4>:</h4>
                        </div>
                        <div class="col-md-5">
                            <span id="ttl_score"><b>
                            @if($explain_score->isNotEmpty())
                                {{$explain_score->first()->total->score}}
                            @else
                                0 
                            @endif
                            </b></span>
                        </div>
                    </div>
                    <div class="row mt-4 col-sm-12 d-flex justify-content-center">
                        <button type="submit" id="submitButton" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            
            window.onload = function() {
            // Kode fungsi yang ingin Anda jalankan saat halaman dimuat
                var selectedKonteks = $("input[name='exampleRadio1']:checked").val();
                var convertedKonteks = convertValue(selectedKonteks);
                var selectedRuntut = $("input[name='exampleRadio2']:checked").val();
                var convertedRuntut = convertValue(selectedRuntut);
                var selectedKebenaran = $("input[name='exampleRadio3']:checked").val();
                var convertedKebenaran = convertValue(selectedKebenaran);

                $('#ibenar').val(convertedKebenaran);
                $('#iruntut').val(convertedRuntut);
                $('#ikonteks').val(convertedKonteks);
                hitungTotal();
            };
            
            $("input[name='exampleRadio1']").change(function(){
                var selectedKonteks = $("input[name='exampleRadio1']:checked").val();
                var convertedKonteks = convertValue(selectedKonteks);

                $('#ikonteks').val(convertedKonteks);
                hitungTotal();
            });

            $("input[name='exampleRadio2']").change(function(){
                var selectedRuntut = $("input[name='exampleRadio2']:checked").val();
                var convertedRuntut = convertValue(selectedRuntut);

                $('#iruntut').val(convertedRuntut);
                hitungTotal();
            });

            $("input[name='exampleRadio3']").change(function(){
                var selectedKebenaran = $("input[name='exampleRadio3']:checked").val();
                var convertedKebenaran = convertValue(selectedKebenaran);

                $('#ibenar').val(convertedKebenaran);
                hitungTotal();
            });

            function hitungTotal(){
                var konteks = $('#ikonteks').val();
                var runtut = $('#iruntut').val();
                var kebenaran = $('#ibenar').val();
                var wondering = $('#iwondering_score').val();
                var exploring = $('#iexploring_score').val();

                konteks=konteks.replace(/\./g,'');
                runtut=runtut.replace(/\./g,'');
                kebenaran=kebenaran.replace(/\./g,'');

                var total_explain = parseInt(konteks) + parseInt(runtut) + parseInt(kebenaran);
                var total_score = parseInt(wondering) + parseInt(exploring) + total_explain;

                
                $('#ttl_explain').text(total_explain);
                $('#ttl_score').text(total_score);
                $('#tot_explain').val(total_explain);
                $('#tot_score').val(total_score);

            }

            $('#add-penilaian').submit(function (e) {
                e.preventDefault();
                
                $.ajax({
                    type: 'POST',
                    url: `{{route('admin.dashboard.add.penilaian')}}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    error: function (err) {
                        
                        Swal.fire(
                            'Error!',
                            "Gagal Menambahkan, Pastikan data terisi dengan benar",
                            'error'
                        );
                    },
                    success: function (response) {
                        if (response.status == 200 || response.status == 201) {
                            Swal.fire(
                                'Success!',
                                'Post data berhasil!',
                                'success'
                            );
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Error Input!',
                                'error'
                            );
                        }
                    },
                })
            });

            function convertValue(value){
                if(value === '1'){
                    return '3';
                }else if(value === '2'){
                    return '5';
                }else if(value === '3'){
                    return '10';
                }else if(value === '4'){
                    return '15';
                }else if(value === '5'){
                    return '20';
                }
                return value;
            }
        });
    </script>
@endsection
