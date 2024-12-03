@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="section-header">
            <h3 class="page__heading">Rubrik Penilaian - {{ $user->name }}</h3>

            <div class="filter-container section-header-breadcrumb row justify-content-md-end">
                <a href="{{ route('admin.dashboard.report', ['user_id' => $user->id]) }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-title mx-2 my-5 border-bottom d-flex justify-content-center align-items-center">
                    <h4 class="m-2 mb-0">{{ $question->question_name }}</h4>

                    <div id="accStatus" class="ms-10">
                        @if ($isAccepted->contains(true))
                            <span class="badge bg-success text-dark">SUDAH DI ACC</span>
                        @else
                            <span class="badge bg-warning text-dark">BELUM ACC</span>
                        @endif
                    </div>
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
                                    @if ($explain_score->isNotEmpty())
                                        {{ $total }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </div>
                        </div>

                        <br>
                        <div>
                            {!! $question->question !!}
                        </div>
                        <br>

                        @foreach ($answer as $index => $answers)
                            @if ($index == 0)
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <span>Pertanyaan</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>:</span>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $answers->essay->question }}
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
                                        {{ $answers->answer }}
                                    </div>
                                </div>
                                <div class="row mt-2">

                                    <input type="hidden" id="essay_question_konteks" name="essay_question_konteks"
                                        value="{{ $answers->essay->id }}">
                                    <input type="hidden" id="user_answer_konteks" name="user_answer_konteks"
                                        value="{{ $answers->id }}">
                                    @if ($explain_score->isNotEmpty())
                                        <div class="col-md-2">
                                            <label for="convertKonteksInput">Nilai Penjelasan sesuai konteks:</label>
                                        </div>
                                        <div class="col-md-1">
                                            <span>:</span>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control" id="convertKonteksInput"
                                                name="convertKonteksInput" value="{{ $convertKonteks }}">
                                        </div>
                                        <input type="hidden" name="id_konteks" value="{{ $id_konteks }}">
                                    @endif
                                </div>
                                <br>
                            @elseif($index == 1)
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <span>Pertanyaan</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>:</span>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $answers->essay->question }}
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
                                        {{ $answers->answer }}
                                    </div>
                                </div>
                                @if ($explain_score->isNotEmpty())
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <span>Keruntutan alur berpikir</span>
                                        </div>
                                        <input type="hidden" id="essay_question_runtut" name="essay_question_runtut"
                                            value="{{ $answers->essay->id }}">
                                        <input type="hidden" id="user_answer_runtut" name="user_answer_runtut"
                                            value="{{ $answers->id }}">
                                        <input type="hidden" name="id_runtut" value="{{ $id_runtut }}">

                                        <div class="col-md-1">
                                            <span>:</span>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control" id="convertRuntutInput"
                                                name="convertRuntutInput" value="{{ $convertRuntut }}">
                                        </div>


                                    </div>
                                @endif
                                <br>
                            @elseif($index == 2)
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <span>Pertanyaan</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span>:</span>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $answers->essay->question }}
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
                                        {{ $answers->answer }}
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <span>Kebenaran jawaban</span>
                                    </div>
                                    <input type="hidden" id="essay_question_kebenaran" name="essay_question_kebenaran"
                                        value="{{ $answers->essay->id }}">
                                    <input type="hidden" id="user_answer_kebenaran" name="user_answer_kebenaran"
                                        value="{{ $answers->id }}">
                                    @if ($explain_score->isNotEmpty())
                                        <div class="col-md-1">
                                            <span>:</span>
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control" id="convertKebenaranInput"
                                                name="convertKebenaranInput" value="{{ $convertKebenaran }}">
                                        </div>
                                        <input type="hidden" name="id_benar" value="{{ $id_benar }}">
                                    @endif
                                </div>
                            @endif
                        @endforeach

                        <div class="row mx-2 my-4 border-bottom border-3">

                        </div>
                        @if ($explain_score->isNotEmpty())
                            <input type="hidden" name="ikonteks" id="ikonteks" value="{{ $convertKonteks }}">
                            <input type="hidden" name="iruntut" id="iruntut" value="{{ $convertRuntut }}">
                            <input type="hidden" name="ibenar" id="ibenar" value="{{ $convertKebenaran }}">
                            <input type="hidden" name="tot_score" id="tot_score"
                                value="{{ $explain_score->first()->total->score }}">
                            <input type="hidden" name="tot_explain" id="tot_explain" value="{{ $total }}">
                        @else
                            <input type="hidden" name="ikonteks" id="ikonteks">
                            <input type="hidden" name="iruntut" id="iruntut">
                            <input type="hidden" name="ibenar" id="ibenar">
                            <input type="hidden" name="tot_score" id="tot_score">
                            <input type="hidden" name="tot_explain" id="tot_explain">
                        @endif
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="question_id" id="question_id" value="{{ $question->id }}">
                        <input type="hidden" name="content_id" id="content_id" value="{{ $content->id }}">
                        <input type="hidden" name="wondering_id" id="wondering_id" value="{{ $read->id }}">
                        <input type="hidden" name="exploring_id" id="exploring_id" value="{{ $coding->id }}">

                        <div class="row mt-2">
                            <div class="col-md-5">
                                <h4>Total Score</h4>
                            </div>
                            <div class="col-md-2">
                                <h4>:</h4>
                            </div>
                            <div class="col-md-5">
                                <span id="ttl_score"><b>
                                        @if ($explain_score->isNotEmpty())
                                            {{ $explain_score->first()->total->score }}
                                        @else
                                            0
                                        @endif
                                    </b></span>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12 d-flex justify-content-center">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="accCheckbox" name="acc" value="true" class="form-check-input">
                                    <label for="accCheckbox" class="form-check-label">ACC</label>
                                </div>
                        
                                <button type="submit" id="submitButton" class="btn btn-primary ml-2">SAVE</button>
                                <a href="{{ url()->previous() }}" class="btn btn-light ml-2">Cancel</a>
                            </div>
                        </div>
                        

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(".form-control").on('input', function() {
                var id = $(this).attr('id');
                var value = $(this).val();

                // Hapus semua karakter selain digit angka
                value = value.replace(/\D/g, '');

                // // Batasi nilai antara 0 hingga 20
                // if (value === '' || parseInt(value) < 0) {
                //     value = '0';
                // } else if (parseInt(value) > 20) {
                //     value = '20';
                // }

                $(this).val(value);

                // Tampilkan peringatan jika nilai di luar rentang
                if (parseInt(value) < 0 || parseInt(value) > 20) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').html('Nilai harus antara 0 hingga 20.');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').html('');
                }


                // Update nilai sesuai dengan id input yang diperoleh
                if (id === 'convertKonteksInput') {
                    $('#ikonteks').val(value);
                } else if (id === 'convertRuntutInput') {
                    $('#iruntut').val(value);
                } else if (id === 'convertKebenaranInput') {
                    $('#ibenar').val(value);
                }

                hitungTotal(); // Hitung total setelah nilai diubah
            });

            function hitungTotal() {
                var konteks = $('#ikonteks').val();
                var runtut = $('#iruntut').val();
                var kebenaran = $('#ibenar').val();
                var wondering = $('#iwondering_score').val();
                var exploring = $('#iexploring_score').val();

                konteks = konteks.replace(/\./g, '');
                runtut = runtut.replace(/\./g, '');
                kebenaran = kebenaran.replace(/\./g, '');

                var total_explain = parseInt(konteks) + parseInt(runtut) + parseInt(kebenaran);
                var total_score = parseInt(wondering) + parseInt(exploring) + total_explain;


                $('#ttl_explain').text(total_explain);
                $('#ttl_score').text(total_score);
                $('#tot_explain').val(total_explain);
                $('#tot_score').val(total_score);

            }

            // $('#add-penilaian').submit(function(e) {
            //     e.preventDefault();

            //     $.ajax({
            //         type: 'POST',
            //         url: `{{ route('admin.dashboard.add.penilaian') }}`,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         data: new FormData(this),
            //         dataType: 'JSON',
            //         contentType: false,
            //         cache: false,
            //         processData: false,
            //         error: function(err) {

            //             Swal.fire(
            //                 'Error!',
            //                 "Gagal Menambahkan, Pastikan data terisi dengan benar",
            //                 'error'
            //             );
            //         },
            //         success: function(response) {
            //             if (response.status == 200 || response.status == 201) {
            //                 Swal.fire(
            //                     'Success!',
            //                     'Update data berhasil!',
            //                     'success'
            //                 );
            //                 location.reload();
            //             } else {
            //                 Swal.fire(
            //                     'Error!',
            //                     'Error Input!',
            //                     'error'
            //                 );
            //             }
            //         },
            //     })
            // });

            $('#add-penilaian').submit(function(e) {
                e.preventDefault();

                // Mendapatkan nilai checkbox acc
                var acc = $('#accCheckbox').is(':checked');

                // Mengirimkan data form beserta nilai acc
                var formData = new FormData(this);
                formData.append('acc', acc);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.dashboard.add.penilaian') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    error: function(err) {
                        Swal.fire(
                            'Error!',
                            "Gagal Menambahkan, Pastikan data terisi dengan benar",
                            'error'
                        );
                    },
                    success: function(response) {
                        if (response.status == 200 || response.status == 201) {
                            Swal.fire(
                                'Success!',
                                'Update data berhasil!',
                                'success'
                            );
                            location.reload(); // Reload halaman setelah berhasil
                        } else {
                            Swal.fire(
                                'Error!',
                                'Error Input!',
                                'error'
                            );
                        }
                    },
                });
            });


        });
    </script>
@endsection
