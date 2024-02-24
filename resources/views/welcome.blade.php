@extends('app')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <div class="text-center mb-4 pb-2">
                    <a href="{{ route('login') }}">
                        <h1 class="text-white">Mudik Bersama Kemenkes</h1>
                    </a>

                    <p class="text-white h4">
                        Pendaftaran 26 Februari - 8 Maret 2024 <br>
                        <small class="h6">*Selama Kuota Masih Tersedia</small>
                    </p>

                    <!-- <a href="{{ route('form.create') }}" class="btn custom-btn smoothscroll mt-3">Daftar Sekarang</a> -->
                    <a href="{{ route('tiket.check') }}" class="btn btn-danger bg-danger hover:bg-primary custom-btn smoothscroll mt-3">Cek Pendaftaran</a>
                </div>

                <div class="owl-carousel owl-theme">
                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/solo.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Solo
                                    </a>
                                </h5>

                                <p class="badge mb-0">1 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="#" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/palembang.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Palembang
                                    </a>
                                </h5>

                                <p class="badge mb-0">1 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/padang.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Padang
                                    </a>
                                </h5>

                                <p class="badge mb-0">1 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/purworejo.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Purworejo
                                    </a>
                                </h5>

                                <p class="badge mb-0">2 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/yogyakarta.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Yogyakarta
                                    </a>
                                </h5>

                                <p class="badge mb-0">3 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="owl-carousel-info-wrap item">
                        <div class="custom-block custom-block-overlay owl-carousel-info">
                            <a href="" class="custom-block-image-wrap">
                                <img src="{{ asset('dist/img/kota/surabaya.jpg') }}" class="custom-block-image img-fluid" alt="">
                            </a>

                            <div class="custom-block-info custom-block-overlay-info">
                                <h5 class="mb-1">
                                    <a href="listing-page.html">
                                        Surabaya
                                    </a>
                                </h5>

                                <p class="badge mb-0">2 Perjalanan</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
