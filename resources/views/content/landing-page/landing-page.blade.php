@extends('layouts_landing/app')

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


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0" id="home">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="m-0">FitApp</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#home" class="nav-item nav-link active">Home</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#feature" class="nav-item nav-link">Feature</a>
                        <a href="#pricing" class="nav-item nav-link">Pricing</a>
                        <a href="#review" class="nav-item nav-link">Review</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Start
                        Free Trial</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container px-lg-5">
                    <div class="row g-5">
                        <div class="col-lg-8 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated slideInDown">The Revolutionary App That Helps To Control
                                Your Own Fitness</h1>
                            <p class="text-white pb-3 animated slideInDown">Tempor rebum no at dolore lorem clita rebum
                                rebum ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit
                                justo amet ipsum vero ipsum clita lorem</p>
                            <a href=""
                                class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill me-3 animated slideInLeft">Read
                                More</a>
                            <a href=""
                                class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Contact
                                Us</a>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp"
                            data-wow-delay="0.3s">
                            <div class="owl-carousel screenshot-carousel">
                                <img class="img-fluid" src="{{ asset('assets/img/landing/screenshot-1.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('assets/img/landing/screenshot-2.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('assets/img/landing/screenshot-3.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('assets/img/landing/screenshot-4.png') }}"
                                    alt="">
                                <img class="img-fluid" src="{{ asset('assets/img/landing/screenshot-5.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        {{-- Semua Event --}}
        <div class="container-xxl py-5" id="feature">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <h5 class="text-primary-gradient fw-medium">Daftar
                        <h1 class="mb-5">Kegiatan Event XX</h1>
                </div>
                <div class="row g-4">
                    @foreach ($data as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s"
                            style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                            <div class="feature-item bg-light rounded p-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4"
                                    style="width: 60px; height: 60px;">
                                    <i class="fa fa-eye text-white fs-4"></i>
                                </div>
                                <h5 class="mb-3">Kegiatan : {{ $item->nama_kegiatan }}</h5>
                                <p class="m-0">Penyelenggara : {{ $item->penyelenggara }}</p>
                                <p class="m-0">Lokasi : {{ $item->tempat }}</p>
                                <p class="m-0">Tanggal : {{ date('d F Y', strtotime($item->tgl_mulai)) }} -
                                    {{ date('d F Y', strtotime($item->tgl_selesai)) }}
                                </p>
                                <button class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill mt-3"
                                    id="pendaftaran" data-id="{{ $item->id }}">Read
                                    More</button>
                                {{-- <p class="m-0"><a href="#">Daftar Event</a></p> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- End Semua Event --}}

        <!-- Contact Start -->
        <div class="container-xxl py-5" id="contact">
            <div class="container py-5 px-lg-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="text-primary-gradient fw-medium">Daftar</h5>
                    <h1 class="mb-5">Join With Us!</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <form method="post" id="addPesertaForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nama"
                                                placeholder="Your Name">
                                            <label for="nama">Nama</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="asal"
                                                placeholder="Asal Instansi">
                                            <label for="subject">Asal Instansi</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control" placeholder="Leave a message here"
                                                id="no_tlp">
                                            <label for="message">No Telp (wa)</label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary-gradient rounded-pill py-3 px-5" type="button"
                                            id="addBtn">Daftar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        {{-- Modal Daftar Kegiatan --}}
        <div class="modal fade show" id="pendaftaranModal" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"></h5>
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
                                    <input id="no_peserta" class="form-control" type="text"
                                        placeholder="Nama Kegiatan ...">
                                    <button class="btn btn-primary btn-sm" id="cekNo">Cek No. Peserta</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="defaultInput" class="form-label">Nama</label>
                                <input id="nama_peserta" class="form-control" type="text"
                                    placeholder="Penyelenggara ...">
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
        {{-- End Modal --}}

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Address</h4>
                        <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Quick Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Popular Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">Career</a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h4 class="text-white mb-4">Newsletter</h4>
                        <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non
                            vulpu</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary-gradient fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                            </br>
                            Distributed By <a class="border-bottom" href="https://themewagon.com"
                                target="_blank">ThemeWagon</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
    </div>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#addBtn', function(e) {
            e.preventDefault();
            console.log('daftar = ' + $('#nama').val());
            // var formData = $('#addPesertaForm').serialize();
            var formData = new FormData();
            formData.append('nama', $('#nama').val())
            formData.append('asal', $('#asal').val())
            formData.append('no_tlp', $('#no_tlp').val())

            $.ajax({
                url: "{{ route('store') }}", // Sesuaikan dengan rute yang benar
                type: "POST",
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
                        title: "Data Created"
                    }).then(() => {
                        location.reload();
                        reload();

                    });
                    // Handle respons setelah berhasil menambahkan data
                },
                error: function(error) {
                    console.log(error);
                    // Handle error jika terjadi
                }
            });
        })

        $(document).on('click', '#pendaftaran', function(e) {
            $('#pendaftaranModal').modal('show');
            var id = $(this).data('id')
            console.log(id)

            $.ajax({
                url: "{{ route('getDataKegiatan', ':id') }}".replace(':id',
                    id), // Sesuaikan dengan rute yang benar
                type: "GET",
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response)
                    $('#title').text('Pendaftaran ' + response.data[0].nama_kegiatan);
                }
            })

        })
        $(document).on('click', '#cekNo', function(e) {
            var no_peserta = $('#no_peserta').val()
            console.log(no_peserta)
            // $.ajax({
            //     url: "{{ route('cekPeserta', ':id') }}".replace(':id',
            //         no_peserta), // Sesuaikan dengan rute yang benar
            //     type: "GET",
            //     processData: false,
            //     contentType: false,
            //     success: function(response) {
            //         $('#nama_peserta').val(response.peserta[0].nama_peserta);
            //         $('#asal').val(response.peserta[0].asal_instansi);
            //         $('#no_tlp').val(response.peserta[0].no_tlp);
            //     }
            // })

        })
    </script>
@endPush
