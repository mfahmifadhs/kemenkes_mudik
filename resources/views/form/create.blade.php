@extends('form.layout.app')
@section('content')

<style>
    :root {
        --kemenkes-blue: #00A9E0;
        --kemenkes-green: #20C997;
    }

    .registration-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: none;
        padding: 40px;
        transition: all 0.3s ease;
    }

    .form-label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: var(--kemenkes-blue);
        box-shadow: 0 0 0 0.2rem rgba(0, 169, 224, 0.15);
    }

    .input-group-text {
        background: none;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--kemenkes-blue);
    }

    .input-group .form-control {
        border-left: none;
    }

    .section-title {
        border-left: 4px solid var(--kemenkes-green);
        padding-left: 15px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #2c3e50;
    }

    .doc-reminder {
        background: #fff5f5;
        border-radius: 12px;
        padding: 15px;
        border-left: 4px solid #ff4d4d;
    }

    .btn-next {
        background: linear-gradient(135deg, var(--kemenkes-blue), #007bb5);
        color: white;
        padding: 12px 40px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 169, 224, 0.3);
        transition: transform 0.2s;
    }

    .btn-next:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 6px 20px rgba(0, 169, 224, 0.4);
    }
</style>

<style>
    /* Tab Navigasi Bus */
    .nav-pills .nav-link {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        background: #fff;
        color: #444;
        transition: all 0.3s;
        padding: 10px 20px;
    }

    .nav-pills .nav-link.active {
        background: var(--kemenkes-blue) !important;
        border-color: var(--kemenkes-blue);
        box-shadow: 0 4px 12px rgba(0, 169, 224, 0.2);
    }

    /* Bus Layout Container */
    .bus-container {
        background: #f8f9fa;
        border-radius: 25px;
        padding: 30px 15px;
        border: 2px solid #eee;
        max-width: 650px;
        margin: 0 auto;
    }

    /* Driver Section */
    .driver-section {
        border-bottom: 2px dashed #ccc;
        margin-bottom: 25px;
        padding-bottom: 15px;
    }

    .steering-wheel {
        width: 40px;
        height: 40px;
        border: 4px double #666;
        border-radius: 50%;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
    }

    /* Seat Styling */
    .seat-label {
        display: block;
        width: 100%;
        padding: 12px 0;
        margin: 4px 0;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
        border: none !important;
    }

    /* Seat Status Colors */
    .seat-available {
        background-color: #e1f5fe;
        color: #0288d1;
    }

    /* Biru Muda */
    .seat-available:hover {
        background-color: #b3e5fc;
    }

    .seat-booked {
        background-color: #ffe082;
        color: #856404;
        cursor: not-allowed;
    }

    /* Kuning (Booked) */
    .seat-full {
        background-color: #e0e0e0;
        color: #9e9e9e;
        cursor: not-allowed;
    }

    /* Abu-abu (Full) */

    /* Checkbox Hidden but Active */
    .seat-checkbox {
        display: none;
    }

    .seat-checkbox:checked+span {
        background-color: var(--kemenkes-green) !important;
        color: white !important;
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--kemenkes-green);
    }

    .toilet-box {
        background: #f1f1f1;
        border-radius: 8px;
        color: #777;
        font-size: 0.7rem;
        padding: 10px 0;
    }
</style>

<section class="hero-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <div class="text-center mb-2 pb-2">
                    <a href="{{ route('login') }}">
                        <h1 class="text-white">Formulir Registrasi Peserta</h1>
                    </a>

                    <p class="text-white">Pastikan seluruh informasi diisi dengan tepat dan benar.</p>
                </div>
                <div class="custom-block custom-block-full col-md-8 mx-auto mb-5">
                    @if (!$step )
                    <div id="identitas">
                        <form id="form" action="{{ route('form.post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="step" value="1">

                            <h4 class="section-title mt-4">Identitas Pegawai</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Utama*</label>
                                    <select id="utamaSelect" name="utama" class="form-control" required>
                                        <option value="">-- Pilih Unit Utama --</option>
                                        @foreach($utama as $row)
                                        <option value="{{ $row->id_unit_utama }}">{{ $row->nama_unit_utama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Kerja*</label>
                                    <select id="ukerSelect" name="uker" class="form-control" required>
                                        <option value="">-- Pilih Unit Kerja --</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nama UPT</label>
                                    <input type="text" class="form-control" name="nama_upt" placeholder="Contoh: RSUP Dr. Kariadi">
                                    <small class="text-muted"><i class="fa fa-info-circle"></i> Kantor Pusat tidak wajib mengisi.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap*</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Sesuai KTP" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP/NIK*</label>
                                    <input type="text" class="form-control number" name="nip_nik" maxlength="18" placeholder="Masukkan 18 digit" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. WhatsApp/Telepon*</label>
                                    <input type="text" class="form-control number" name="no_telp" maxlength="16" placeholder="0812..." required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Aktif*</label>
                                    <input type="email" class="form-control" name="email" placeholder="contoh@mail.com" required>
                                    <small class="text-danger" style="font-size: 0.75rem;">Hasil verifikasi akan dikirim ke email ini.</small>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Alamat Lengkap Domisili*</label>
                                    <textarea class="form-control" name="alamat" rows="2" placeholder="Jl. Nama Jalan No. RT/RW, Kecamatan, Kota" required></textarea>
                                </div>
                            </div>

                            <h4 class="section-title mt-4">Rute Perjalanan</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Rute Tujuan Trayek*</label>
                                    <select id="ruteSelect" name="rute" class="form-control" required>
                                        <option value="">-- Pilih Rute --</option>
                                        @foreach ($trayek as $row)
                                        <option value="{{ $row->id_trayek }}">{{ $row->jurusan }} - {{ $row->rute }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kota Tujuan Spesifik*</label>
                                    <select id="destSelect" name="dest" class="form-control" required>
                                        <option value="">-- Pilih Kota --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="doc-reminder my-4">
                                <p class="mb-2" style="font-weight: 600; color: #d63031;">
                                    <i class="fa fa-file-invoice"></i> Persiapan Dokumen (Step Berikutnya):
                                </p>
                                <ul class="mb-0" style="font-size: 0.85rem; color: #444;">
                                    <li>Foto KTP (Format JPG/PNG)</li>
                                    <li>Foto Kartu Keluarga</li>
                                </ul>
                            </div>

                            <div class="text-center">
                                <button type="submit" id="submitBtn" class="btn btn-next">
                                    <span id="buttonText">Selanjutnya </span>
                                    <i id="buttonIcon" class="fa fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    @elseif ($rute && $step == 1)
                    <div id="bus">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary mb-1">{{ ucfirst(strtolower($rute->jurusan)) }}</h3>
                            <p class="text-muted"><i class="fa fa-route me-2"></i>{{ $rute->rute }}</p>
                            <hr class="w-25 mx-auto">
                        </div>

                        @php
                        $formAction = !$seatFull ? route('form.post') : route('form.store');
                        $formMethod = !$seatFull ? 'POST' : 'POST';
                        @endphp

                        <form id="form" action="{{ $formAction }}" method="{{ $formMethod }}" enctype="multipart/form-data">
                            @csrf
                            @if($seatFull)
                            <input type="hidden" name="seatFull" value="true">
                            <input type="hidden" name="peserta" value="{{ implode(',', $peserta) }}">
                            <input type="hidden" name="id_book" value="{{ $bookId }}">
                            @endif
                            <input type="hidden" name="step" value="2">
                            <input type="hidden" name="rute" value="{{ $rute->id_trayek }}">
                            <input type="hidden" name="data" value="{{ json_encode($data) }}">

                            <ul class="nav nav-pills justify-content-center mb-5" id="tab" role="tablist">
                                @foreach ($bus as $key => $row)
                                <li class="nav-item px-2 my-2">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-toggle="pill" href="#bus-{{ $row->id_bus }}">
                                        <div class="text-center">
                                            <span class="d-block fw-bold">BUS {{ $row->id_bus }}</span>
                                            <small class="{{ $row->total_kursi - $row->detail->count() > 0 ? 'text-success' : 'text-danger' }}">
                                                Sisa {{ $row->total_kursi - $row->detail->where('kode_seat', '!=', null)->where('status', '!=', 'cancel')->count() }} Kursi
                                            </small>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="tabContent">
                                @foreach ($bus as $key => $row)
                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="bus-{{ $row->id_bus }}">

                                    <div class="bus-container shadow-sm">
                                        <div class="row driver-section text-center align-items-center">
                                            <div class="col-5"><span class="badge bg-light text-dark p-2 border">Co-Driver</span></div>
                                            <div class="col-2"></div>
                                            <div class="col-5">
                                                <div class="steering-wheel">STER</div>
                                                <small class="text-muted">Driver</small>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-5">
                                                @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                                    <div class="row g-1 mb-1">
                                                        @foreach (json_decode($row->kd_seat_kiri, true) as $kode)
                                                        @php $seatCode = $i . $kode . $row->id_bus; @endphp
                                                        <div class="col-6 text-center">
                                                            @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                                            <span class="seat-label seat-booked">{{ $i.$kode }}</span>
                                                            @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                                            <span class="seat-label seat-full">{{ $i.$kode }}</span>
                                                            @else
                                                            <label class="w-100">
                                                                <input name="seat[]" type="checkbox" class="seat-checkbox" value="{{ $row->id_bus.'-'.$i.$kode }}">
                                                                <span class="seat-label seat-available">{{ $i.$kode }}</span>
                                                            </label>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endfor
                                            </div>

                                            <div class="col-2 text-center">
                                                <div class="h-100 border-start border-end border-light opacity-50"></div>
                                            </div>

                                            <div class="col-5">
                                                @for ($i = 1; $i <= $row->seat_kanan; $i++)
                                                    <div class="row g-1 mb-1">
                                                        @foreach (json_decode($row->kd_seat_kanan, true) as $kode)
                                                        @php $seatCode = $i . $kode . $row->id_bus; @endphp
                                                        <div class="col-6 text-center">
                                                            @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                                            <span class="seat-label seat-booked">{{ $i.$kode }}</span>
                                                            @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                                            <span class="seat-label seat-full">{{ $i.$kode }}</span>
                                                            @else
                                                            <label class="w-100">
                                                                <input name="seat[]" type="checkbox" class="seat-checkbox" value="{{ $row->id_bus.'-'.$i.$kode }}">
                                                                <span class="seat-label seat-available">{{ $i.$kode }}</span>
                                                            </label>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endfor
                                            </div>
                                        </div>

                                        @if ($row->total_kursi == 40 || $row->total_kursi == 36 || $row->total_kursi == 50)
                                        <div class="row mt-3 g-2 align-items-center">
                                            <div class="col-4 text-center">
                                                <div class="toilet-box fw-bold"><i class="fa fa-restroom"></i> TOILET</div>
                                            </div>
                                            <div class="col-8">
                                                <div class="row g-1">
                                                    @foreach (json_decode($row->kd_seat_belakang, true) as $kode)
                                                    <div class="col-3 text-center">
                                                        <label class="w-100">
                                                            <input name="seat[]" type="checkbox" class="seat-checkbox" value="{{ $row->id_bus.'-12'.$kode }}">
                                                            <span class="seat-label seat-full">12{{ $kode }}</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center gap-3 mt-4 text-sm small">
                                <div><span class="badge seat-available p-2">&nbsp;&nbsp;</span> Tersedia</div>
                                <div><span class="badge bg-success p-2">&nbsp;&nbsp;</span> Anda Pilih</div>
                                <div><span class="badge seat-booked p-2">&nbsp;&nbsp;</span> Booking</div>
                                <div><span class="badge seat-full p-2">&nbsp;&nbsp;</span> Terisi</div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-12 text-center mb-3">
                                    @if($seatFull)
                                    <a href="#" class="text-primary text-decoration-none small fw-bold" data-toggle="modal" data-target="#skModal">
                                        <u>Baca Syarat & Ketentuan</u>
                                    </a>
                                    @endif
                                </div>

                                <div class="col-6">
                                    @if (!$seatFull)
                                    <button type="button" onclick="goBack()" class="btn btn-outline-secondary w-100 rounded-pill p-2">
                                        <i class="fa fa-arrow-left me-2"></i> Sebelumnya
                                    </button>
                                    @else
                                    <a href="{{ route('form.create') }}" class="btn btn-outline-danger w-100 rounded-pill p-2">
                                        <i class="fa fa-times-circle me-2"></i> Batalkan
                                    </a>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <button type="submit" id="submitBtn" class="btn btn-next w-100 rounded-pill p-2"
                                        @if($seatFull) onclick="confirmBook(event, 'Selesai', 'Mohon periksa kembali data Anda.')" @endif>
                                        <span>{{ !$seatFull ? 'Selanjutnya' : 'Selesai' }}</span>
                                        <i class="fa {{ !$seatFull ? 'fa-arrow-right' : 'fa-check-circle' }} ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @elseif ($step == 2)
                    <div id="peserta">
                        <div class="mb-4 text-center">
                            <h4 class="fw-bold text-primary mb-1">{{ ucfirst(strtolower($rute->jurusan)) }}</h4>
                            <p class="text-muted small">{{ $rute->rute }}</p>
                        </div>

                        <form id="form" action="{{ route('form.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="step" value="2">
                            <input type="hidden" name="rute" value="{{ $rute->id_trayek }}">
                            <input type="hidden" name="data" value="{{ json_encode($data) }}">
                            <div class="mb-4">
                                <h5><b>Informasi Peserta</b></h5>
                                <small>
                                    Mohon untuk mengisi dan melengkapi Nama Lengkap dan NIK peserta.
                                </small>
                            </div>

                            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Informasi Peserta</h5>
                                    <div class="alert alert-info border-0 p-2 mb-4" style="font-size: 11px; background-color: #eef7ff;">
                                        <i class="fas fa-info-circle me-1"></i> Mohon untuk mengisi dan melengkapi Nama Lengkap, Usia, serta NIK sesuai dokumen asli.
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="small fw-bold mb-1">Foto KTP <small class="text-muted">(Maks. 5MB)</small></label>
                                            <input type="file" name="foto_ktp" class="form-control form-control-sm border-info" required accept=".jpg, .jpeg, .png">
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="small fw-bold mb-1">Kartu Keluarga <small class="text-muted">(Maks. 5MB)</small></label>
                                            <input type="file" name="foto_kk" class="form-control form-control-sm border-info" required accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($seat as $key => $row)
                            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge rounded-circle bg-primary me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">{{ $loop->iteration }}</span>
                                        <h6 class="fw-bold mb-0">Data Peserta {{ $loop->iteration }}</h6>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-12 mb-2">
                                            <div class="p-2 border rounded-3 bg-light d-flex justify-content-around">
                                                <div class="small">Bus: <span class="fw-bold text-primary">{{ explode('-', $row, 2)[0] }}</span></div>
                                                <div class="vr"></div>
                                                <div class="small">Kursi: <span class="fw-bold text-primary">{{ explode('-', $row, 2)[1] }}</span></div>
                                            </div>
                                            <input type="hidden" name="bus[]" value="{{ explode('-', $row, 2)[0] }}">
                                            <input type="hidden" name="seat[]" value="{{ explode('-', $row, 2)[1] }}">
                                        </div>

                                        <div class="col-12 col-md-6 mb-2">
                                            <label class="small text-muted mb-0">Nama Lengkap</label>
                                            <input type="text" name="peserta[]" class="form-control form-control-sm shadow-none" placeholder="Sesuai KTP" required>
                                        </div>

                                        <div class="col-4 col-md-2 mb-2">
                                            <label class="small text-muted mb-0">Usia</label>
                                            <input type="text" name="usia_peserta[]" class="form-control form-control-sm number text-center shadow-none" maxlength="2" placeholder="Thn" required>
                                        </div>
                                        <div class="col-8 col-md-4 mb-2">
                                            <label class="small text-muted mb-0">NIK</label>
                                            <input type="text" name="nik_peserta[]" class="form-control form-control-sm number shadow-none" maxlength="16" placeholder="16 digit NIK" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p class="text-right text-primary underline ">
                                            <a href="#" data-toggle="modal" data-target="#skModal">
                                                <b><u>Syarat dan ketentuan</u></b>
                                            </a>
                                        </p>

                                        <div class="modal fade" id="skModal" role="dialog" aria-labelledby="skLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="skLabel">
                                                            <a href="#">Syarat dan Ketentuan</a>
                                                        </h5>
                                                        <button type="button" class="close btn custom-btn smoothscroll" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-sm" style="text-align: left;">
                                                        <p class="mb-2">Syarat dan Ketentuan Peserta Bus Mudik Kemenkes Tahun 2026:</p>
                                                        <ol type="1">
                                                            @foreach ($sk as $row)
                                                            <li>{{ $row->syarat_ketentuan }}</li>
                                                            @endforeach
                                                        </ol>
                                                        <p class="mt-4 text-justify">
                                                            <label style="text-align: justify;">
                                                                <input id="skCheckbox" type="checkbox" name="sk" required>
                                                                Saya telah membaca dan mengerti seluruh Syarat dan Ketentuan Penggunaan Ini dan Konsekuensinya
                                                                dan dengan ini menerima setiap hak, kewajiban, dan ketentuan yang diatur di dalamnya.
                                                            </label>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <a href="javascript:void(0);" onclick="goBack()" class="btn btn-outline-secondary w-100 rounded-pill p-2">
                                            <i class="fa-solid fa-square-caret-left"></i> Sebelumnya
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <button type="submit" id="submitBtn" class="btn btn-next w-100 rounded-pill p-2" onclick="confirmBook(event, 'Selesai', 'Mohon periksa kembali, karena data yang sudah di kirim tidak bisa diubah atau dihapus')">
                                            <span id="buttonText">Selesai </span><i id="buttonIcon" class="fa-solid fa-circle-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $('#btn-identitas').on('click', function() {
            $('#identitas').addClass('d-none')
            $('#bus').removeClass('d-none').addClass('d-block')
        })
    })
</script>

<script>
    document.getElementById('skCheckbox').addEventListener('change', function() {
        if (this.checked) {
            $('#skModal').modal('hide');
        }
    });
</script>

<script>
    function confirmBook(event, title, text) {
        event.preventDefault(); // Mencegah perilaku link bawaan

        // Mengecek setiap input pada formulir
        const form = document.getElementById('form');
        const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
        let isFormValid = true;

        const skCheck = document.getElementById('skCheckbox');
        const isChecked = skCheck.checked;

        if (isChecked == false) {
            console.log('eror')
            isFormValid = false;
            Swal.fire({
                title: 'Gagal',
                text: 'Anda belum menyetujui Syarat dan Ketentuan',
                icon: 'error',
            });
        }

        const seatFull = '{{ $seatFull }}'
        const peserta = '{{ count($peserta) }}'
        if (seatFull) {
            isFormValid = false;
            var checkedCount = $('.seat-checkbox:checked').length;

            if (checkedCount > peserta) {
                $(this).prop('checked', false);
                Swal.fire({
                    text: "Anda hanya dapat memilih " + peserta + " kursi.",
                    icon: 'error',
                });
            } else if (checkedCount < peserta) {
                Swal.fire({
                    text: "Anda harus memilih " + peserta + " kursi.",
                    icon: 'error',
                });
            } else if (checkedCount == peserta && isChecked == true) {
                isFormValid = true;
            }
        }


        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = 'red';
                isFormValid = false;

                Swal.fire({
                    title: 'Gagal',
                    text: 'Anda belum melengkapi kolom',
                    icon: 'error',
                });

                if (input.type === 'file') {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Anda belum upload file ' + input.name,
                        icon: 'error',
                    });
                }
            } else {
                input.style.borderColor = '';
            }
        });

        var seatTotal = '{{ $seatTotal }}'
        const fileImage = document.getElementById('fileImage');

        if (fileImage) {
            const fileImageSize = fileImage.files[0] ? fileImage.files[0].size : '';
            const allowedTypes = ['image/jpeg', 'image/png'];
            if (fileImage) {
                if (fileImageSize > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'File foto harus kurang dari 5 MB',
                        icon: 'error',
                    });
                    isFormValid = false;
                } else if (!allowedTypes.includes(fileImage.files[0].type)) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Tipe file foto harus jpg atau png',
                        icon: 'error',
                    });
                    isFormValid = false;
                }
            }
        }

        // Memeriksa validitas akhir setelah perulangan
        if (isFormValid) {
            // Menampilkan kotak dialog konfirmasi
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Mengirim data...",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                    })

                    form.submit()
                }
            });
        }
    }
</script>

<script>
    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {
        // Tambahkan event listener untuk menangkap perubahan tab
        $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
            // Hapus kelas active dari semua tab
            $('a[data-toggle="pill"]').removeClass('active bg-info');

            // Tambahkan kelas active ke tab yang sedang aktif
            $(e.target).addClass('active bg-info');
        });
    });


    $(document).ready(function() {
        $('.seat-checkbox').change(function() {
            var checkedCount = $('.seat-checkbox:checked').length;
            if (checkedCount > 4) {
                $(this).prop('checked', false);

                Swal.fire({
                    text: "Anda hanya dapat memilih maksimal 4 kursi.",
                    icon: 'error',
                });
            } else {
                $(this).data('count', checkedCount);
                if ($(this).is(':checked')) {
                    $(this).parent().css('background-color', '');
                } else {
                    $(this).parent().css('background-color', ''); // Reset warna jika checkbox tidak dicentang
                }
            }
        });
    });
</script>

<script>
    // When the document is ready
    $(document).ready(function() {
        $('#ruteSelect').change(function() {
            var selectedRuteId = $(this).val();

            $.ajax({
                url: '/tujuan/select/' + selectedRuteId,
                type: 'GET',
                success: function(data) {
                    $('#destSelect').empty();
                    $.each(data, function(key, val) {
                        $('#destSelect').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $('#utamaSelect').change(function() {
            var selectedUtamaId = $(this).val();

            $.ajax({
                url: '/uker/select/' + selectedUtamaId,
                type: 'GET',
                success: function(data) {
                    $('#ukerSelect').empty();
                    $.each(data, function(key, val) {
                        $('#ukerSelect').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

@endsection
@endsection
