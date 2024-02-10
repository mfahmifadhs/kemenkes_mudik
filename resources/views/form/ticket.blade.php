@extends('form.layout.app')

@section('content')

<div class="max-w-7xl mx-auto p-6 lg:p-8">
    <div class="flex justify-center mt-0">
        <div class="card w-50">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="150">
                        <p class="small mt-2 text-justify">
                            Terima kasih telah melakukan registrasi Mudik Bersama Kemenkes!
                        </p>
                        <p class="small m-3">
                        <div class="row small">
                            <div class="col-md-3">Kode Boking</div>
                            <div class="col-md-8">: {{ $book->id_booking }}</div>
                            <div class="col-md-3">Nama Pegawai</div>
                            <div class="col-md-8">: {{ $book->nama_pegawai }}</div>
                            <div class="col-md-3">NIP/NIK</div>
                            <div class="col-md-8">: {{ $book->nip_nik }}</div>
                            <div class="col-md-3">Unit Kerja</div>
                            <div class="col-md-8">: {{ $book->uker->nama_unit_kerja }}</div>
                            <div class="col-md-3">No. Telepon</div>
                            <div class="col-md-8">: {{ $book->no_telp }}</div>
                            <div class="col-md-3">Alamat</div>
                            <div class="col-md-8">: {{ $book->alamat }}</div>
                            <div class="col-md-3">Tujuan</div>
                            <div class="col-md-8">: {{ $book->tujuan->nama_kota }}</div>
                            <div class="col-md-3">Rute</div>
                            <div class="col-md-8">:
                                {{ $book->rute->jurusan }}
                                <p style="margin-left: 0.9vh;"> {{ $book->rute->rute }}</p>
                            </div>
                        </div>
                        </p>
                        <hr class="my-3">
                        <h5 class="my-2">Detail Boking</h5>
                        <p>
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
                        </p>
                        <hr class="my-4">
                        <h5 class="my-2">Kebijakan</h5>
                        <p>
                            <li class="small">Pendaftaran "Mudik Bersama Kemenkes" tidak dapat <b>Dibatalkan/Diubah</b></li>
                            <li class="small">Hasil Pendaftaran akan di verifikasi dalam waktu 2x24 jam (hari kerja) oleh Biro Umum.</li>
                            <li class="small">
                                Hasil verifikasi dapat di cek secara berkala di link berikut: <a href=""><u><b>Hasil Verifikasi</b></u></a>
                            </li>
                            <li class="small">Keputusan akhir Panitia tidak dapat diganggu gugat.</li>
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
</div>

@section('js')

<script>
    $(function() {

    })
</script>

@endsection

@endsection
