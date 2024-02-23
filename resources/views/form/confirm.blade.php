@extends('form.layout.app')

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
                        Pendaftaran 26 Februari - 8 Maret 2024 <br>
                        <small class="h6">*Selama Kuota Masih Tersedia</small>
                    </p>
                </div>
                <div class="custom-block custom-block-full col-md-8 mx-auto mb-5">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="150">
                            <p class="small mt-2 text-justify">
                                Terima kasih telah melakukan registrasi Mudik Bersama Kemenkes!
                            </p>
                        </div>
                        <div class="col-md-9">
                            <table class="w-100 text-sm align-top">
                                <tr>
                                    <td class="align-top" style="width: 23%;">ID</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->kode_booking }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Nama Pegawai</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->nama_pegawai }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">NIP/NIK</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->nip_nik }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Unit Kerja</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->uker->nama_unit_kerja }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">No. Telepon</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->no_telp }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Email</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->email }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Alamat</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->alamat }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Tujuan</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>{{ $book->tujuan->nama_kota }}</td>
                                </tr>
                                <tr>
                                    <td class="align-top" style="width: 23%;">Rute</td>
                                    <td class="align-top" style="width: 2%;">:</td>
                                    <td>
                                        {{ $book->rute->jurusan }} <br>
                                        {{ $book->rute->rute }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3 col-12 text-center my-3">
                            @if (!$book->approval_uker || !$book->approval_roum)
                            <i class="fas fa-history text-warning fa-6x" style="opacity: 0.4;"></i>
                            @endif

                            @if ($book->approval_uker == 'true' || $book->approval_roum == 'true')
                            <i class="fas fa-check-circle text-success fa-6x" style="opacity: 0.4;"></i>
                            @endif

                            @if ($book->approval_uker == 'false' || $book->approval_roum == 'false')
                            <i class="fas fa-times-circle text-danger fa-6x mb-2" style="opacity: 0.4;"></i><br>
                            <span class="text-danger">{{ $book->catatan }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <p class="small m-3">

                                <hr class="my-3">
                            <h5 class="my-2">Detail Pendaftaran</h5>
                            <div class="table-responsive">
                                <table class="table table-striped small text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>NIK</th>
                                            <th>Bus</th>
                                            <th>Kode Kursi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detail as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $row->nama_peserta }}</td>
                                            <td>{{ $row->nik }}</td>
                                            <td>{{ $row->bus_id }}</td>
                                            <td>{{ $row->kode_seat }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <h5 class="my-2">Catatan</h5>
                            <p>
                                <li class="small">Peserta diharapkan menyimpan Kode Booking yang telah didapatkan</li>
                                <li class="small">Pendaftaran "Mudik Bersama Kemenkes" tidak dapat Dibatalkan/diubah tanpa persetujuan panitia</li>
                                <li class="small">Selanjutnya akan dilakukan verifikasi oleh PIC Mudik Bersama Kemenkes pada masing-masing Sekretariat Unit Utama atau Subbagian Administrasi Umum pada setiap unit eselon II bagi Unit Utama Sekretariat Jenderal</li>
                                <li class="small">Kemudian akan dilakukan verifikasi akhir oleh Biro Umum</li>
                                <li class="small">
                                    Verifikasi dapat dicek berkala di link berikut: <a href="{{ route('tiket.check') }}"><u>Hasil Verifikasi</u></a>
                                </li>
                                <li class="small">
                                    E-Tiket akan dikirimkan ke alamat email terdaftar, apabila peserta telah lolos verifikasi.
                                </li>
                            </p>
                        </div>
                    </div>
                    <div class="form-group pt-5">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ url('/') }}" class="btn btn-default border-dark text-dark">
                                    <i class="fa-solid fa-home"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection
