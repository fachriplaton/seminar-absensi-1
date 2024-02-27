@extends('layouts_admin/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Kegiatan /</span> Data Kegiatan Peserta</h4>
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-header" style="padding: 0; margin-bottom: 5rem;">
                <span class="float-end">
                    <button type="button" class="btn btn-success" id="tambahBtn">Tambah Peserta</button>
                </span>
                <span class="float-start" style="margin-right:10px">
                    <button type="button" class="btn btn-primary" id="confirmDelete">Delete Selected <i class="bx bx-trash"
                            style="margin-left: 10px"></i></button>
                </span>
                <span class="float-start">
                    <button type="button" class="btn btn-primary" id="importModalBtn">Import Excel <i class="bx bx-table"
                            style="margin-left: 10px"></i></button>
                </span>

            </div>

            <input id="id_kegiatan" value="{{ $id_kegiatan }}" hidden />
            <table id="dataKegiatan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        {{-- <th><input type="checkbox" id="master"</th> --}}
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>No Peserta</th>
                        <th>Asal</th>
                        <th>No Urut</th>
                        {{-- <th>Kegiatan</th> --}}
                        <th>No tlp</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Kegiatan Peserta --}}
    <div class="modal fade show" id="modalTambahKegiatan" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Kegiatan Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="addKegiatan">
                        {{-- <div class="input-group">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary" type="button" id="button-addon2">Button</button>
                        </div> --}}

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">No Peserta</label>
                            <div class="input-group">
                                <input id="no_peserta" class="form-control" type="text" placeholder="Nama Kegiatan ...">
                                <button class="btn btn-primary btn-sm" id="cekNo">Cek No. Peserta</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Nama</label>
                            <input id="nama_peserta" class="form-control" type="text" placeholder="Penyelenggara ...">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Asal Instansi</label>
                            <input id="asal" class="form-control" type="text" placeholder="Tempat ...">
                        </div>

                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">No. Telp</label>
                            <input id="no_tlp" class="form-control" type="text" placeholder="">
                        </div>

                        <select id="dropdownId" class="form-select">
                            <!-- Default option -->
                            <option value="">Pilih Opsi</option>
                        </select>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addKegiatanPesertaBtn" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Kegiatan --}}

    {{-- Modal Import --}}
    <div class="modal fade show" id="modalImport" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Import Data Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="addKegiatan">
                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Pilih Excell</label>
                            <div class="input-group">
                                <input id="fileImport" class="form-control" type="file" accept=".xlsx, .xls">
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="importBtn" type="button" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Import --}}

    {{-- confirm delete --}}
    <div class="modal fade show" id="modalConfirmDelete" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Delete Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h1>Apakah Anda Yakin?</h1>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="deleteSelect" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end confirm delete --}}

    {{-- tes commit --}}
@endsection

@section('page-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#master').on('click', function(e) {

                if ($(this).is(':checked', true)) {
                    // console.log('master cheked')
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }

            });
            var id = $('#id_kegiatan').val()
            console.log('id = ' + id)

            function message(message) {
                let el = document.querySelector('#events');
                let div = document.createElement('div');

                div.textContent = message;
                el.prepend(div);
            }

            var selected = [];
            var oTable;

            var oTable = $("#dataKegiatan").DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                select: {
                    style: 'multi'
                },
                ajax: {
                    url: "{{ route('getDataPesertaKegiatan', ['id' => ':id']) }}".replace(':id', id),
                    method: 'POST',
                    // dataSrc: function(json) {
                    //     // console.log(json)
                    //     // Memodifikasi data sebelum disertakan dalam tabel
                    //     return json.data.map(function(item) {
                    //         // Menambahkan id ke dalam setiap objek data
                    //         item.id = item.no_peserta;
                    //         return item;
                    //     });
                    // },
                },
                rowCallback: function(row, data, dataIndex) {
                    console.log('rowCallback Data = ' + data.id)
                    // Menandai baris yang sudah dipilih sebelumnya
                    if ($.inArray(data.id, selected) !== -1) {
                        console.log('rowCallback if')
                        $(row).addClass('row_selected selected');
                    }
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    // Mengatur ulang kembali semua elemen yang sudah dipilih
                    api.rows().every(function() {
                        var rowNode = this.node();
                        var rowData = this.data();

                        if ($.inArray(rowData.id, selected) !== -1) {
                            $(rowNode).addClass('row_selected selected');
                        } else {
                            $(rowNode).removeClass('row_selected selected');
                        }
                    });
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        // visible: false
                    },
                    {
                        data: 'nama_peserta',
                        name: 'nama_peserta',
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1
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
                        data: 'no_urut',
                        name: 'no_urut'
                    },
                    {
                        data: 'no_tlp',
                        name: 'no_tlp'
                    },
                    {
                        data: 'status_absen',
                        name: 'status_absen',
                        render: function(data) {
                            if (data === 0) {
                                return '<span class="badge bg-label-danger">Belum Hadir</span>';
                            } else {
                                return '<span class="badge bg-label-success">Hadir</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            $('#dataKegiatan tbody').on('click', 'tr', function() {
                var data = oTable.row(this).data();
                var iId = data.id;

                // Memantau status seleksi
                if ($(this).hasClass('selected')) {
                    selected = $.grep(selected, function(value) {
                        return value != iId;
                    });

                } else {
                    selected.push(iId);
                }

                $(this).toggleClass('row_selected selected');
                $(document).on('click', '#deleteSelect', function(e) {
                    console.log('Selected = ' + selected)
                    $.ajax({
                        url: "{{ route('deleteMultiSelect') }}",
                        method: 'POST',
                        data: {
                            id: selected
                        },
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
                                title: "Data Peserta Deleted"
                            }).then(() => {
                                location.reload();
                                reload();

                            });
                        },
                    });


                })
            });

            $.ajax({
                url: "{{ route('getDataDropdown') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus opsi yang ada sebelumnya
                    $('#dropdownId').empty();

                    // Menambahkan opsi dari data yang diterima
                    $.each(response.kegiatan, function(index, item) {
                        $('#dropdownId').append('<option value="' + item.id + '">' + item
                            .nama_kegiatan + '</option>');
                    });
                },
                error: function(error) {
                    console.error(error);
                    // Lakukan sesuatu jika terjadi error
                }
            });
        });

        $(document).on('click', '#confirmDelete', function(e) {
            $('#modalConfirmDelete').modal('show')
        });

        $(document).on('click', '#tambahBtn', function(e) {
            e.preventDefault();
            $('#modalTambahKegiatan').modal('show');

            $(document).on('click', '#addKegiatanPesertaBtn', function(e) {
                var formData = new FormData();
                formData.append('nama_keg', $('#nama_keg').val())
                formData.append('penyelenggara', $('#penyelenggara').val())
                formData.append('tempat', $('#tempat').val())
                formData.append('tgl_mulai', $('#tgl_mulai').val())
                formData.append('tgl_selesai', $('#tgl_selesai').val())
                formData.append('jumlah_jam', $('#jumlah_jam').val())

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

        $(document).on('click', '#cekNo', function(e) {
            e.preventDefault();
            var no_peserta = $('#no_peserta').val();

            $.ajax({
                url: "{{ route('cekDataPeserta', ':id') }}".replace(':id',
                    no_peserta), // Ganti dengan URL yang sesuai
                type: 'get',
                // data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#nama_peserta').val(response.peserta[0].nama_peserta);
                    $('#asal').val(response.peserta[0].asal_instansi);
                    $('#no_tlp').val(response.peserta[0].no_tlp);
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data.');
                }
            });

        })

        $(document).on('click', '#importModalBtn', function(e) {
            $('#modalImport').modal('show');

            $(document).on('click', '#importBtn', function(e) {
                console.log('import')
                var id_kegiatan = $('#id_kegiatan').val()
                var fileInput = $('#fileImport')[0].files[0] // Mendapatkan file yang dipilih

                var formData = new FormData()
                formData.append('file', fileInput) // Membuat objek FormData
                formData.append('id_kegiatan', id_kegiatan)

                $.ajax({
                    url: "{{ route('import') }}",
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
                            title: "Import File Sukses"
                        }).then(() => {
                            location.reload();
                            reload();

                        });

                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat data.');
                    }
                });

            })

        })




        // var oTable;
        // var selected = new Array();


        // $(document).ready(function() {
        //     $('#form').submit(function() {
        //         alert(selected);
        //         return false;
        //     });

        //     /* Init the table */
        //     oTable = $("#example").dataTable({
        //         "bProcessing": true,
        //         "bServerSide": true,
        //         "sAjaxSource": "../examples_support/server_processing_post.php",
        //         "fnServerData": function(sSource, aoData, fnCallback) {
        //             $.ajax({
        //                 "dataType": 'json',
        //                 "type": "POST",
        //                 "url": sSource,
        //                 "data": aoData,
        //                 "success": fnCallback
        //             });
        //         },
        //         "fnRowCallback": function(nRow, aData, iDisplayIndex) {
        //             $('#example tbody tr').each(function() {
        //                 if (jQuery.inArray(aData[0], selected) != -1) {
        //                     $(this).addClass('row_selected');
        //                 }
        //             });
        //             return nRow;
        //         },
        //         "fnDrawCallback": function(oSettings) {
        //             $('#example tbody tr').each(function() {
        //                 var iPos = oTable.fnGetPosition(this);
        //                 if (iPos != null) {
        //                     var aData = oTable.fnGetData(iPos);
        //                     if (jQuery.inArray(aData[0], selected) != -1)
        //                         $(this).addClass('row_selected');
        //                 }
        //                 $(this).click(function() {
        //                     var iPos = oTable.fnGetPosition(this);
        //                     var aData = oTable.fnGetData(iPos);
        //                     var iId = aData[0];
        //                     is_in_array = jQuery.inArray(iId, selected);
        //                     if (is_in_array == -1) {
        //                         selected[selected.length] = iId;
        //                     } else {
        //                         selected = jQuery.grep(selected, function(value) {
        //                             return value != iId;
        //                         });
        //                     }
        //                     if ($(this).hasClass('row_selected')) {
        //                         $(this).removeClass('row_selected');
        //                     } else {
        //                         $(this).addClass('row_selected');
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });
    </script>
@endsection
