@extends('form.layout.app')

@section('content')

<div class="max-w-7xl mx-auto p-6 lg:p-8">
    <div class="flex justify-center mt-0">
        <div class="card col-md-6 col-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="150">
                        <p class="small mt-2 text-justify">
                            Terima kasih telah melakukan registrasi Mudik Bersama Kemenkes!
                        </p>
                        <p class="small m-3">
                        <div class="row small">
                            <div class="col-md-3 col-3">Kode Boking</div>
                            <div class="col-md-8 col-8">: {{ $book->kode_booking }}</div>
                            <div class="col-md-3 col-3">Nama Pegawai</div>
                            <div class="col-md-8 col-8">: {{ $book->nama_pegawai }}</div>
                            <div class="col-md-3 col-3">NIP/NIK</div>
                            <div class="col-md-8 col-8">: {{ $book->nip_nik }}</div>
                            <div class="col-md-3 col-3">Unit Kerja</div>
                            <div class="col-md-8 col-8">: {{ $book->uker->nama_unit_kerja }}</div>
                            <div class="col-md-3 col-3">No. Telepon</div>
                            <div class="col-md-8 col-8">: {{ $book->no_telp }}</div>
                            <div class="col-md-3 col-3">Alamat</div>
                            <div class="col-md-8 col-8">: {{ $book->alamat }}</div>
                            <div class="col-md-3 col-3">Tujuan</div>
                            <div class="col-md-8 col-8">: {{ $book->tujuan->nama_kota }}</div>
                            <div class="col-md-3 col-3">Rute</div>
                            <div class="col-md-8 col-8">:
                                {{ $book->rute->jurusan }}
                                <p style="margin-left: 0.9vh;"> {{ $book->rute->rute }}</p>
                            </div>
                        </div>
                        </p>
                        <hr class="my-3">
                        <h5 class="my-2">Detail Boking</h5>
                        <p class="table-responsive">
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
                            <li class="small">Peserta diharapkan menyimpan Kode Booking yang telah didapatkan</li>
                            <li class="small">Pendaftaran "Mudik Bersama Kemenkes" tidak dapat Dibatalkan/diubah tanpa persetujuan panitia</li>
                            <li class="small">Selanjutnya akan dilakukan verifikasi oleh PIC Mudik Bersama Kemenkes pada masing-masing Sekretariat Unit Utama atau Subbagian Administrasi Umum pada setiap unit eselon II bagi Unit Utama Sekretariat Jenderal</li>
                            <li class="small">Kemudian akan dilakukan verifikasi akhir oleh Biro Umum</li>
                            <li class="small">
                                Verifikasi dapat dicek berkala di link berikut: <a href="{{ route('tiket.check') }}"><u>Hasil Verifikasi</u></a>
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
</div>

@section('js')

<script>
    $(function() {

    })
</script>

@endsection

@endsection
