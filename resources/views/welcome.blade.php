@extends('app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --kemenkes-blue: #00529b;
        --kemenkes-teal: #00a79d;
        --kemenkes-dark: #003366;
    }

    .hero-title {
        font-weight: 800;
        font-size: 3.5rem;
        letter-spacing: -1.5px;
        margin-bottom: 20px;
    }

    .info-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        padding: 30px;
        display: inline-block;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .custom-btn-main {
        background: #ffcc00;
        /* Warna kuning peringatan yang kontras */
        color: #003366;
        font-weight: 700;
        border: none;
        padding: 15px 35px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .custom-btn-main:hover {
        background: #ffd633;
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-glass {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
        font-weight: 500;
        padding: 10px 25px;
        border-radius: 50px;
        transition: all 0.3s;
    }

    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        border-color: white;
    }

    .custom-block-overlay {
        border-radius: 24px;
        overflow: hidden;
        background: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        height: 100%;
    }

    .custom-block-overlay:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .badge-destinasi {
        background: #e6f6f5;
        color: var(--kemenkes-teal);
        font-weight: 700;
        font-size: 0.75rem;
        padding: 6px 16px;
        border-radius: 50px;
        text-transform: uppercase;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 28px;
        border: none;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 25px 30px 10px;
    }

    .modal-body {
        padding: 10px 30px 30px;
    }

    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #25d366;
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        z-index: 9999;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .whatsapp-float i {
        font-size: 24px;
    }

    .whatsapp-float:hover {
        background-color: #128c7e;
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Sembunyikan teks di layar kecil agar jadi lingkaran saja */
    @media (max-width: 768px) {
        .wa-text {
            display: none;
        }

        .whatsapp-float {
            padding: 15px;
            bottom: 20px;
            right: 20px;
        }
    }

    .btn-register {
        background: linear-gradient(135deg, #00a79d 0%, #00529b 100%);
        color: white;
        font-weight: 800;
        font-size: 1.2rem;
        padding: 18px 45px;
        border-radius: 50px;
        border: none;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-register:hover {
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 167, 157, 0.4);
    }
</style>

<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-12">
                <h1 class="hero-title">Mudik Bersama Kemenkes 2026</span></h1>
                <p class="text-white mb-4 fw-bold" style="font-size: 1.1rem;">
                    Siapkan dokumen untuk Pendaftaran <span class="text-warning fw-bold">(KTP dan KK Pendaftar)</span>
                </p>

                <div class="info-card mb-4">
                    <div class="d-flex flex-column flex-md-row gap-md-5 align-items-center">
                        <div>
                            <small class="text-white-50 d-block mb-1">Periode Pendaftaran</small>
                            <h5 class="mb-0 fw-bold"><i class="bi-calendar-check me-2"></i>Soon</h5>
                        </div>
                        <div class="vr d-none d-md-block opacity-25"></div>
                        <hr class="d-md-none w-100 opacity-25">
                        <div>
                            <small class="text-white-50 d-block mb-1">Jadwal Keberangkatan</small>
                            <h5 class="text-warning mb-0 fw-bold"><i class="bi-bus-front me-2"></i>Soon</h5>
                        </div>
                    </div>
                </div>

                <!-- <div class="mb-4">
                    <a href="{{ route('form.create') }}" class="btn custom-btn-main shadow">
                        <i class="bi-hand-index me-2"></i> Daftar Sekarang
                    </a>
                </div> -->

                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                    <a href="{{ route('tiket.check') }}" class="btn btn-glass shadow">
                        <i class="bi-search me-2"></i> Cek Status Pendaftaran
                    </a>
                    <button class="btn btn-glass shadow" data-bs-toggle="modal" data-bs-target="#modalSyarat">
                        <i class="bi-file-earmark-text me-2"></i> Syarat & Ketentuan
                    </button>
                    <button class="btn btn-glass shadow" data-bs-toggle="modal" data-bs-target="#modalRute">
                        <i class="bi-geo-alt me-2"></i> Rute Perjalanan
                    </button>
                </div>

                <div class="owl-carousel owl-theme">
                    @php
                    $cities = [
                    ['name' => 'Solo', 'img' => 'solo.jpg'],
                    ['name' => 'Palembang', 'img' => 'palembang.jpg'],
                    ['name' => 'Padang', 'img' => 'padang.jpg'],
                    ['name' => 'Purworejo', 'img' => 'purworejo.jpg'],
                    ['name' => 'Yogyakarta', 'img' => 'yogyakarta.jpg'],
                    ['name' => 'Surabaya', 'img' => 'surabaya.jpg'],
                    ];
                    @endphp

                    @foreach($cities as $city)
                    <div class="item p-2">
                        <div class="custom-block-overlay">
                            <img src="{{ asset('dist/img/kota/'.$city['img']) }}" class="img-fluid" alt="{{ $city['name'] }}" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="p-4 text-start">
                                <h5 class="text-dark fw-bold mb-2">{{ $city['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

<a href="https://wa.me/6281211121365?text=Halo%20Admin%20Mudik%20Kemenkes%2C%20saya%20ingin%20bertanya..."
    class="whatsapp-float"
    target="_blank"
    rel="noopener noreferrer">
    <i class="bi bi-whatsapp"></i>
    <span class="wa-text">Hubungi Admin</span>
</a>

<div class="modal fade" id="modalSyarat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="bi-info-circle text-primary me-2"></i>Syarat & Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($data->sk as $row)
                <div class="d-flex mb-3">
                    <i class="bi-check-circle-fill text-success me-3 mt-1"></i>
                    <p class="mb-0 text-muted">{{ $row->syarat_ketentuan }}.</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRute" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="bi-map text-primary me-2"></i>Rute & Jalur Mudik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead class="text-muted small text-uppercase">
                            <tr>
                                <th style="width: 20%;">Destinasi</th>
                                <th>Jalur Utama</th>
                                <th>Bus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->trayek as $row)
                            <tr class="border-bottom">
                                <td><strong>{{ $row->jurusan }}</strong></td>
                                <td>{{ $row->rute }}</td>
                                <td class="text-center">{{ $row->bus->where('status', 'true')->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
