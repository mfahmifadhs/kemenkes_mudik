@extends('app')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <div class="text-center mb-5 pb-2">
                    <a href="{{ route('login') }}">
                        <h1 class="text-white">Mudik Bersama Kemenkes</h1>
                    </a>

                    <p class="text-white">Pendaftaran 26 Februari - 8 Maret 2024</p>
                </div>
                <div class="custom-block custom-block-full col-md-5 mx-auto">
                    <form id="form" action="{{ route('post.login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <small class="me-4">Username</small>
                            <input type="text" class="form-control border-dark rounded" name="username" required>
                        </div>
                        <div class="form-group mt-3">
                            <small class="me-4">Password</small>
                            <div class="input-group">
                                <input type="password" class="form-control border-dark" id="password" name="password" placeholder="Masukkan Password" required>
                                <div class="input-group-append border border-dark">
                                    <span class="input-group-text h-100 rounded-0 bg-white">
                                        <i class="fas fa-eye" id="eye-icon-pass"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        </div>
                        <div class="form-group mt-5 text-right">
                            <button type="submit" class="btn custom-btn smoothscroll mt-3" onclick="confirmSubmit(event, 'Masuk', 'Pastikan data sudah terisi dengan benar')">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
