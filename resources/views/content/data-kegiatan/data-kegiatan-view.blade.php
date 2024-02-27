@extends('layouts_admin/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kegiatan /</span>Data Kegiatan</h4>
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-header text-end" style="padding: 0; margin-bottom:2rem;">
                <button type="button" class="btn btn-success" id="tambahBtn">Tambah Kegiatan</button>
            </div>
            <table id="dataKegiatan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tempat</th>
                        <th>Tanggal(Mulai - Selesai)</th>
                        <th>Jam Mulai</th>
                        <th>Jumlah Jam</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Kegiatan --}}
    <div class="modal fade show" id="modalTambahKegiatan" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="addKegiatan">

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Nama Kegiatan</label>
                            <input id="nama_keg" class="form-control" type="text" placeholder="Nama Kegiatan ...">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Penyelenggara</label>
                            <input id="penyelenggara" class="form-control" type="text" placeholder="Penyelenggara ...">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Tempat</label>
                            <input id="tempat" class="form-control" type="text" placeholder="Tempat ...">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Tanggal Mulai</label>
                            <input id="tgl_mulai" class="form-control" type="date" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Tanggal Selesai</label>
                            <input id="tgl_selesai" class="form-control" type="date" placeholder="">
                        </div>

                        <div class="form-password-toggle">
                            <label class="form-label" for="basic-default-password12">Jam Mulai</label>
                            <div class="input-group">
                                <input type="text" placeholder=".. : .." class="form-control" id="timePicker">
                                <span id="time" class="input-group-text cursor-pointer"><i
                                        class="bx bxs-time"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Jumlah Jam</label>
                            <input id="jumlah_jam" class="form-control" type="text" placeholder="">
                        </div>

                        {{-- <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="time">Time</label>
                                    <div class="input-group date" id="timePicker">
                                        <input type="text" class="form-control timePicker">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addKegiatanBtn" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Kegiatan --}}
@endsection

@section('page-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var firstOpen = true;
            var time;
            $('#timePicker').datetimepicker({
                useCurrent: false,
                format: "hh:mm A"
            }).on('dp.show', function() {
                if (firstOpen) {
                    time = moment().startOf('day');
                    firstOpen = false;
                } else {
                    time = moment().format('hh:mm A');
                }
                $(this).data('DateTimePicker').date(time);
            });

            $('#dataKegiatan').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('getDataKegiatan') }}",
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'penyelenggara',
                        name: 'penyelenggara'
                    },
                    {
                        data: 'tempat',
                        name: 'tempat'
                    },
                    {
                        data: function(row) {
                            if (row.tgl_mulai && row.tgl_selesai) {
                                return moment(row.tgl_mulai).format('DD MMMM YYYY') + ' - ' +
                                    moment(row.tgl_selesai).format('DD MMMM YYYY');
                            } else {
                                return 'Selesai';
                            }
                        },
                        name: 'tgl_mulai'
                    },
                    {
                        data: 'jam_mulai',
                        name: 'jam_mulai'
                    },
                    {
                        data: 'jumlah_jam',
                        name: 'jumlah_jam'
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

        $(document).on('click', '#tambahBtn', function(e) {
            e.preventDefault();
            $('#modalTambahKegiatan').modal('show');

            $(document).on('click', '#addKegiatanBtn', function(e) {
                var time = $('#timePicker').val()
                var formattedTime = moment(time, 'hh:mm A').format('HH:mm:ss')
                console.log(time)
                var formData = new FormData();
                formData.append('nama_keg', $('#nama_keg').val())
                formData.append('penyelenggara', $('#penyelenggara').val())
                formData.append('tempat', $('#tempat').val())
                formData.append('tgl_mulai', $('#tgl_mulai').val())
                formData.append('tgl_selesai', $('#tgl_selesai').val())
                formData.append('jumlah_jam', $('#jumlah_jam').val())
                formData.append('jam_mulai', formattedTime)
                $.ajax({
                    url: "{{ route('data-kegiatan.store') }}", // Ganti dengan URL yang sesuai
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
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

        })
    </script>
@endsection
