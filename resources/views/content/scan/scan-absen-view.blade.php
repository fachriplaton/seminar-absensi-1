@extends('layouts_landing/app')
@push('styles')
    <style>
        .cstm #reader {
            margin-top: 2rem !important;
        }
    </style>
@endPush
@section('content')
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Contact Start -->
        <div class="container-xxl py-5" id="contact">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium"></h5>
                    <h4 class="text-primary-gradient mb-1">Absensi Kegiatan {{ $data_kegiatan->nama_kegiatan }}</h4>
                    <h1 class="mb-5">SCAN DISINI</h1>
                </div>

                <div class="col-lg-4 col-sm-6 text-center pt-4 wow fadeInUp mx-auto" data-wow-delay="0.1s">
                    <div class="position-relative bg-light rounded pt-5 pb-4 px-4 cstm">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle position-absolute top-0 start-50 translate-middle shadow"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-cog fa-3x text-white"></i>
                        </div>
                        <div id="loadingMessage" style="display:none;">Memindai...</div>
                        <div id="reader" width="600px" style="display: block"></div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="wow fadeInUp" data-wow-delay="0.3s">

                            {{-- <form method="post" id="addPesertaForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="id_kegiatan" value="{{ $data_kegiatan->id }}" hidden>
                                            <input type="text" class="form-control" id="sukses"
                                                placeholder="Your Name">
                                            <label for="nama">Nama</label>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <video></video>
        <!-- Contact End -->

        {{-- tesst --}}
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            const audio = new Audio('assets/audio/success.mp3');
            let scanningEnabled = 1;
            console.log('scanningEnabled = ' + scanningEnabled)

            function showLoading() {
                $('#reader').css('display', 'none');
                $('#loadingMessage').show();
            }

            function hideLoading() {
                console.log('masuk hide')
                $('#reader').css('display', 'block');
                $('#loadingMessage').hide();
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (scanningEnabled) {
                    scanningEnabled = 0;
                    console.log(`Code matched = ${decodedText}`, decodedResult);
                    let id = decodedText;

                    $.ajax({
                        url: "{{ route('dataPeserta', ':id') }}".replace(':id', id),
                        type: 'get',
                        beforeSend: function() {
                            audio.play()
                            showLoading()
                        },
                        success: function(response) {
                            // console.log('data = ' + response.data.nama_peserta)
                            // $('#sukses').val(response.data.nama_peserta)
                            let id_peserta = response.data.no_peserta
                            let id_kegiatan = $('#id_kegiatan').val()

                            $.ajax({
                                url: "{{ route('updateAbsenPeserta') }}",
                                type: 'post',
                                data: {
                                    id_peserta: id_peserta,
                                    id_kegiatan: id_kegiatan
                                },
                                success: function(response) {
                                    console.log('data = ' + response.nama_peserta)
                                    alert('Peserta ' + response.nama_peserta +
                                        ' berhasil melakukan absen pada kegiatan = ' +
                                        response.nama_kegiatan);
                                    $('#sukses').val(response.nama_peserta)
                                },
                                error: function(xhr, status, error) {
                                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage += ' - ' + xhr.responseJSON.message;
                                    }
                                    $('#pesanError').text('Terjadi kesalahan: ' +
                                        errorMessage);
                                }

                            });
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat memuat data.');
                        },
                        complete: function() {
                            scanningEnabled = 1;
                            hideLoading()
                        }
                    });

                }

                let no_peserta = $('#sukses').val(sukses);

            }


            function onScanFailure(error) {
                console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                false
            );

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>
@endPush
