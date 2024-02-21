@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid mx-auto col-md-10">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <small>Edit Peserta <small>{{ $book->id_booking }}</small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('peserta') }}">Daftar Peserta</a></li>
                        <li class="breadcrumb-item active">Edit Peserta</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto col-md-10">
                <div class="card-header">
                    <label class="card-title">
                        Edit Registrasi Peserta
                    </label>
                </div>
                <form action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Informasi Pegawai</label>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Unit utama</label>
                                    <select name="utama" class="form-control col-md-9">
                                        @foreach($utama as $row)
                                        @php $utamaSelect = $row->id_unit_utama == $book->uker->unit_utama_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_unit_utama }}" {{ $utamaSelect }}>
                                            {{ $row->nama_unit_utama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Unit kerja</label>
                                    <select name="uker" class="form-control col-md-9">
                                        @foreach($uker as $row)
                                        @php $ukerSelect = $row->id_unit_kerja == $book->uker_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_unit_kerja }}" {{ $ukerSelect }}>
                                            {{ $row->nama_unit_kerja }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Nama pegawai</label>
                                    <input type="text" name="nama_pegawai" class="form-control col-md-9" value="{{ $book->nama_pegawai }}">
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">NIP/NIK</label>
                                    <input type="text" name="nip_nik" class="form-control col-md-9" value="{{ $book->nip_nik }}">
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">No. Telepon</label>
                                    <input type="text" name="no_telp" class="form-control col-md-9" value="{{ $book->no_telp }}">
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Email</label>
                                    <input type="email" name="email" class="form-control col-md-9" value="{{ $book->email }}">
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Alamat</label>
                                    <textarea name="alamat" class="form-control col-md-9">{{ $book->alamat }}</textarea>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Rute tujuan</label>
                                    <select name="uker" class="form-control col-md-9">
                                        @foreach($rute as $row)
                                        @php $ruteSelect = $row->id_trayek == $book->trayek_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_trayek }}" {{ $ruteSelect }}>
                                            {{ $row->jurusan }} - {{ $row->rute }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Rute tujuan</label>
                                    <select name="uker" class="form-control col-md-9">
                                        @foreach($tujuan as $row)
                                        @php $tujuanSelect = $row->id_detail == $book->tujuan_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_detail }}" {{ $tujuanSelect }}>
                                            {{ $row->nama_kota }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 px-5">
                                <label>Informasi Peserta</label>
                                @foreach ($book->detail as $peserta)
                                <h6>Peserta {{ $loop->iteration }}</h6>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Nama Peserta</label>
                                    <input type="text" name="nama_peserta" class="col-md-9 form-control form-control-sm" value="{{ $peserta->nama_peserta }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">NIK</label>
                                    <input type="text" name="nik" class="col-md-9 form-control form-control-sm" value="{{ $peserta->nik }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Usia</label>
                                    <input type="text" name="usia" class="col-md-9 form-control form-control-sm" value="{{ $peserta->usia }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Bus</label>
                                    <select name="uker" class="form-control form-control-sm col-md-2 text-center">
                                        @foreach($bus as $row)
                                        @php $busSelect = $row->id_bus == $peserta->bus_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_bus }}" {{ $busSelect }}>
                                            Bus {{ $row->id_bus }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label class="mt-1 col-md-3 text-center">Kursi</label>
                                    <input type="text" name="usia" class="col-md-2 form-control form-control-sm text-center" value="{{ $peserta->kode_seat }}">
                                </div>
                                <div class="row text-xs mt-1">
                                    <div class="col-md-3"></div>
                                    @php
                                    $link1 = !$peserta->foto_vaksin_1 ? '#' : "data-toggle=\"modal\" data-target=\"#btn1{$peserta->id_peserta}\"";
                                    $btn1 = !$peserta->foto_vaksin_1 ? 'btn-success' : 'btn-danger';
                                    @endphp
                                    <a type="button" class="col-md-3" {!! $link1 !!}>
                                        <span class="btn {{ $btn1 }} btn-xs">
                                            <i class="fas fa-id-card"></i> <br> Sertifikat Vaksin 1</span>
                                    </a>
                                    @php
                                    $link2 = !$peserta->foto_vaksin_2 ? '#' : "data-toggle=\"modal\" data-target=\"#btn2{$peserta->id_peserta}\"";
                                    $btn2 = !$peserta->foto_vaksin_2 ? 'btn-success' : 'btn-danger';
                                    @endphp
                                    <a type="button" class="col-md-3" {!! $link2 !!}>
                                        <span class="btn {{ $btn2 }} btn-xs">
                                            <i class="fas fa-id-card"></i> <br> Sertifikat Vaksin 2
                                        </span>
                                    </a>
                                    @php
                                    $link3 = !$peserta->foto_vaksin_3 ? '#' : "data-toggle=\"modal\" data-target=\"#btn3{$peserta->id_peserta}\"";
                                    $btn3 = !$peserta->foto_vaksin_3 ? 'btn-success' : 'btn-danger';
                                    @endphp
                                    <a type="button" class="col-md-3" {!! $link3 !!}>
                                        <span class="btn {{ $btn3 }} btn-xs">
                                            <i class="fas fa-id-card"></i> <br> Sertifikat Vaksin 3
                                        </span>
                                    </a>
                                </div>
                                @if ($book->detail->count() != 1)
                                <hr> @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><br>
</div>

@foreach ($book->detail as $peserta)
<!-- Vaksin 1 -->
<div class="modal fade" id="btn1{{ $peserta->id_peserta }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-img-1" src="{{ asset('storage/files/vaksin_1/' . $peserta->foto_vaksin_1) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_1 }}</h6>
                        <form action="{{ route('book.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_1" class="foto-vaksin-1">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            <a href class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vaksin 2 -->
<div class="modal fade" id="btn2{{ $peserta->id_peserta }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-img-2" src="{{ asset('storage/files/vaksin_2/' . $peserta->foto_vaksin_2) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_2 }}</h6>
                        <form action="{{ route('book.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_2" class="foto-vaksin-2">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            <a href class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vaksin 3 -->
<div class="modal fade" id="btn3{{ $peserta->id_peserta }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-img-3" src="{{ asset('storage/files/vaksin_3/' . $peserta->foto_vaksin_3) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_3 }}</h6>
                        <form action="{{ route('book.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_3" class="foto-vaksin-3">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            <a href class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    $(function() {
        // Preview Foto
        for (let i = 1; i < 4; i++) {
            $('.foto-vaksin-' + i).change(function() {
                let reader = new FileReader();
                console.log(reader);
                reader.onload = (e) => {
                    $(`#preview-img-${i}`).attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });
        }

    });
</script>
@endsection
@endsection
