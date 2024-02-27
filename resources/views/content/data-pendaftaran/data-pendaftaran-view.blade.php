@extends('layouts_admin/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Data Peserta </h4>
    <div class="card mb-4">
        <div class="card-body">
            <table id="dataPeserta" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>No Peserta</th>
                        <th>Asal Instansi</th>
                        <th>No Telp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL QRCODE --}}
    <div class="modal fade" id="modalqrcode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">QR CODE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='modalimg'></div>
                </div>
                <div class="modal-footer">
                    <button id="downloadqr" class="btn btn-success btn-download">DOWNLOAD</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL Kegiatan --}}
    <div class="modal fade show" id="modalKegiatan" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Kegiatan Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->has('selectedKeg'))
                        <div class="alert alert-danger">
                            <!-- Tampilkan pesan kesalahan -->
                            {{ $errors->first('selectedKeg') }}
                        </div>
                    @endif
                    {{-- <div class="alert alert-danger">
                            {{ $errors->first('selectedKegiatan') }}
                        </div> --}}
                    <form method="post" id="addKegiatan">
                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">No Peserta</label>
                            <input id="no_peserta" class="form-control" type="text" placeholder="Nama Kegiatan ...">
                        </div>

                        <div class="card-body">
                            <div class="row gy-3">
                                <small class="text-light fw-medium">Checkboxes</small>
                                @foreach ($kegiatan as $item)
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                                id="chekbox{{ $item->id }}">
                                            <label class="form-check-label" for="defaultCheck1"
                                                style=" max-width: 150px;
                                        word-wrap: break-word;">
                                                {{ $item->nama_kegiatan }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addKegiatanPesertaBtn" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Kegiatan --}}

@endsection

@section('page-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#dataPeserta').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('getDataPendaftaran') }}",
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_peserta',
                        name: 'nama_peserta'
                    },
                    {
                        data: 'no_peserta',
                        name: 'no_peserta'
                    },
                    {
                        data: 'asal_instansi',
                        name: 'asal_instansi'
                    },
                    {
                        data: 'no_tlp',
                        name: 'no_tlp'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                createdRow: function(row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                }
            });
        });
        $(document).on('click', '#qrcode', function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            $.ajax({
                url: "{{ route('generateQr') }}", // Ganti dengan URL yang sesuai
                type: 'post',
                data: {
                    id: id
                }, // Kirim ID sebagai parameter
                success: function(response) {
                    // Isi modal dengan konten dari respons
                    $('.modalimg').html('<center><img id="preview" src="' + response
                        .qrcode + '" class="img-fluid"></center>');
                    $('#modalqrcode').modal('show');
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data.');
                }
            });
        })

        $(document).on('click', '#kegiatan', function(e) {
            var no_peserta = $(this).data('id');
            console.log(no_peserta)
            $('#no_peserta').val(no_peserta);
            $('#modalKegiatan').modal('show');
        })

        $(document).on('click', '#addKegiatanPesertaBtn', function(e) {
            e.preventDefault();
            // Mendapatkan semua elemen checkbox
            // var checkboxes = document.querySelectorAll('.form-check-input');
            var selectedKegiatan = [];
            $('input[type="checkbox"]:checked').each(function() {
                selectedKegiatan.push($(this).val());
            });

            // const id = $('#no_peserta').val();
            var formData = new FormData();
            formData.append('no_peserta', $('#no_peserta').val())
            formData.append('selectedKegiatan', JSON.stringify(selectedKegiatan));

            console.log(formData);
            $.ajax({
                url: "{{ route('addKegiatan') }}", // Ganti dengan URL yang sesuai
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#modalKegiatan').modal('hide');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        },
                        customContainerClass: 'swal-custom-container'
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Data Kegiatan Created"
                    }).then(() => {
                        location.reload();
                        reload();

                    });
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data.');
                }
            });
        });
    </script>
@endsection
