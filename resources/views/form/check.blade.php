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

                    <p class="text-white h4">
                        Pendaftaran 05 Maret - 14 Maret 2025 <br>
                        <small class="h6">*Selama Kuota Masih Tersedia</small>
                    </p>
                </div>
                <div class="custom-block custom-block-full col-md-5 mx-auto">
                    <form id="form" action="{{ route('form.confirm.check') }}" method="POST">
                        @csrf
                        <div class="form-group text-center">
                            <label>Masukkan Kode Pendaftaran atau NIK/NIP</label>
                            <input type="number" class="form-control form-control-lg text-center rounded border border-dark number" maxlength="18" name="kode" required>
                        </div>
                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn custom-btn smoothscroll mt-3 text-center" onclick="confirmSubmit(event, 'Cek', 'Cek Kode Boking')">
                                <i class="fa-solid fa-magnifying-glass"></i> Check
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
