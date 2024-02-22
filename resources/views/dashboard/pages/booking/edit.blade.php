@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid mx-auto col-md-10">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <small>Edit Peserta <small>({{ $book->kode_booking }})</small></small>
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
            <form id="form" action="{{ route('book.update', $book->id_booking) }}" method="POST">
                @csrf
                <div class="card mx-auto col-md-10">
                    <div class="card-header">
                        <label class="card-title">
                            Edit Registrasi Peserta
                        </label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Informasi Pegawai</label>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Unit utama</label>
                                    <select id="utamaSelect" name="utama" class="form-control col-md-9">
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
                                    <select id="ukerSelect" name="uker_id" class="form-control col-md-9">
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
                                    <select id="ruteSelect" name="trayek_id" class="form-control col-md-9">
                                        @foreach($rute as $row)
                                        @php $ruteSelect = $row->id_trayek == $book->trayek_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_trayek }}" {{ $ruteSelect }}>
                                            {{ $row->jurusan }} - {{ $row->rute }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">Kota tujuan</label>
                                    <select id="destSelect" name="tujuan_id" class="form-control col-md-9">
                                        @foreach($tujuan as $row)
                                        @php $tujuanSelect = $row->id_detail == $book->tujuan_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_detail }}" {{ $tujuanSelect }}>
                                            {{ $row->nama_kota }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row form-group">
                                    <label class="col-form-label col-md-3">File KTP</label>
                                    <div class="col-md-3 mt-2">
                                        <a type="button" data-toggle="modal" data-target="#modal-ktp">
                                            <img src="{{ asset('storage/files/foto_ktp/' . $book->foto_ktp) }}" class="img-fluid border border-dark">
                                        </a>
                                    </div>

                                    <label class="col-form-label col-md-3 text-center">File KK</label>
                                    <div class="col-md-3 mt-2">
                                        <a type="button" data-toggle="modal" data-target="#modal-kk">
                                            <img src="{{ asset('storage/files/foto_kk/' . $book->foto_kk) }}" class="img-fluid border border-dark">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 px-5">
                                <label>Informasi Peserta</label>
                                @foreach ($book->detail as $peserta)
                                <input type="hidden" name="id_peserta[]" value="{{ $peserta->id_peserta }}">
                                <h6>Peserta {{ $loop->iteration }}</h6>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Nama Peserta</label>
                                    <input type="text" name="nama_peserta[]" class="col-md-9 form-control form-control-sm" value="{{ $peserta->nama_peserta }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">NIK</label>
                                    <input type="text" name="nik[]" class="col-md-9 form-control form-control-sm" value="{{ $peserta->nik }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Usia</label>
                                    <input type="text" name="usia[]" class="col-md-9 form-control form-control-sm" value="{{ $peserta->usia }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Bus</label>
                                    <select name="bus_id[]" class="form-control form-control-sm col-md-2 text-center">
                                        @foreach($bus as $row)
                                        @php $busSelect = $row->id_bus == $peserta->bus_id ? 'selected' : ''; @endphp
                                        <option value="{{ $row->id_bus }}" {{ $busSelect }}>
                                            Bus {{ $row->id_bus }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label class="mt-1 col-md-3 text-center">Kursi</label>
                                    <input type="text" name="kode_seat[]" class="col-md-2 form-control form-control-sm text-center" value="{{ $peserta->kode_seat }}">
                                </div>
                                <div class="row">
                                    <label class="mt-1 col-md-3">Status</label>
                                    <select name="status[]" class="col-md-7 form-control form-control-sm">
                                        <option value="book" <?php echo $peserta->status == 'book' ? 'selected' : ''; ?>>Dipesan</option>
                                        <option value="full" <?php echo $peserta->status == 'full' ? 'selected' : ''; ?>>Penuh</option>
                                        <option value="cancel" <?php echo $peserta->status == 'cancel' ? 'selected' : ''; ?>>Batal</option>
                                    </select>
                                </div>
                                <div class="row text-xs mt-1" style="margin-left: -3.1vh;">
                                    <div class="col-md-3"></div>
                                    @php
                                    $link1 = "data-toggle=\"modal\" data-target=\"#btn1{$peserta->id_peserta}\"";
                                    $btn1 = !$peserta->foto_vaksin_1 ? 'btn-danger' : 'btn-success';
                                    @endphp
                                    <a type="button" class="col-md-3" {!! $link1 !!}>
                                        <span class="btn {{ $btn1 }} btn-xs">
                                            <i class="fas fa-id-card"></i> <br> Sertifikat Vaksin 1</span>
                                    </a>
                                    @php
                                    $link2 = "data-toggle=\"modal\" data-target=\"#btn2{$peserta->id_peserta}\"";
                                    $btn2 = !$peserta->foto_vaksin_2 ? 'btn-danger' : 'btn-success';
                                    @endphp
                                    <a type="button" class="col-md-3" {!! $link2 !!}>
                                        <span class="btn {{ $btn2 }} btn-xs">
                                            <i class="fas fa-id-card"></i> <br> Sertifikat Vaksin 2
                                        </span>
                                    </a>
                                    @php
                                    $link3 = "data-toggle=\"modal\" data-target=\"#btn3{$peserta->id_peserta}\"";
                                    $btn3 = !$peserta->foto_vaksin_3 ? 'btn-danger' : 'btn-success';
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
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <div class="card-body text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
        </form>
    </div><br>
</div>

<!-- modal ktp -->
<div class="modal fade" id="modal-ktp" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-ktp" src="{{ asset('storage/files/foto_ktp/' . $book->foto_ktp) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Pegawai</label>
                        <h6>{{ $book->nama_pegawai }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $book->foto_ktp }}</h6>
                        <form action="{{ route('file.update', $book->id_booking) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_ktp" class="foto-ktp" data-id="{{ $book->id_booking }}">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            @if($book->foto_ktp)
                            <a href="{{ route('file.delete', ['file' => 'fotoktp', 'id' => $book->id_booking]) }}" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal kk -->
<div class="modal fade" id="modal-kk" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-kk" src="{{ asset('storage/files/foto_kk/' . $book->foto_kk) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Pegawai</label>
                        <h6>{{ $book->nama_pegawai }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $book->foto_kk }}</h6>
                        <form action="{{ route('file.update', $book->id_booking) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_kk" class="foto-kk" data-id="{{ $book->id_booking }}">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            @if($book->foto_kk)
                            <a href="{{ route('file.delete', ['file' => 'fotokk', 'id' => $book->id_booking]) }}" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($book->detail as $peserta)
<!-- Vaksin 1 -->
<div class="modal fade" id="btn1{{ $peserta->id_peserta }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="preview-img-1-{{ $peserta->id_peserta }}" src="{{ asset('storage/files/vaksin_1/' . $peserta->foto_vaksin_1) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_1 }}</h6>
                        <form action="{{ route('file.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_1" class="foto-vaksin-1" data-id="{{ $peserta->id_peserta }}">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            @if($peserta->foto_vaksin_1)
                            <a href="{{ route('file.delete', ['file' => 'vaksin1', 'id' => $peserta->id_peserta]) }}" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            @endif
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
                        <img id="preview-img-2-{{ $peserta->id_peserta }}" src="{{ asset('storage/files/vaksin_2/' . $peserta->foto_vaksin_2) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_2 }}</h6>
                        <form action="{{ route('file.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_2" class="foto-vaksin-2" data-id="{{ $peserta->id_peserta }}">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            @if($peserta->foto_vaksin_2)
                            <a href="{{ route('file.delete', ['file' => 'vaksin2', 'id' => $peserta->id_peserta]) }}" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            @endif
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
                        <img id="preview-img-3-{{ $peserta->id_peserta }}" src="{{ asset('storage/files/vaksin_3/' . $peserta->foto_vaksin_3) }}" class="img-fluid mt-3">
                    </div>
                    <div class="col-md-6">
                        <label>Nama Peserta</label>
                        <h6>{{ $peserta->nama_peserta }}</h6>
                        <label>Nama File</label>
                        <h6>{{ $peserta->foto_vaksin_3 }}</h6>
                        <form action="{{ route('file.update', $peserta->id_peserta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Upload Foto</label>
                            <h6>
                                <div class="btn btn-default btn-file border-secondary form-control">
                                    <i class="fas fa-paperclip"></i> Upload Foto
                                    <input type="file" name="foto_vaksin_3" class="foto-vaksin-3" data-id="{{ $peserta->id_peserta }}">
                                    <small>(Max. 5mb)</small>
                                </div>
                            </h6>
                            <button type="submit" class="btn btn-xs btn-success"><i class="fas fa-save"></i> Simpan</button>
                            @if($peserta->foto_vaksin_3)
                            <a href="{{ route('file.delete', ['file' => 'vaksin3', 'id' => $peserta->id_peserta]) }}" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            @endif
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
        // Disable input
        let role = '{{ Auth::user()->role_id }}'
        let form = document.getElementById('form');

        if (role == 4) {
            const formElements = form.querySelectorAll('input, select, textarea');
            formElements.forEach(element => {
                if (element.type !== 'file') {
                    element.disabled = true;
                    element.classList.add('bg-white');
                }
            });
        }

        // Preview KTP
        $('.foto-ktp').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                console.log('hai')
                $(`#preview-ktp`).attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });

        // Preview KK
        $('.foto-kk').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $(`#preview-kk`).attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        });

        // Preview Foto
        for (let i = 1; i < 4; i++) {
            $('.foto-vaksin-' + i).change(function() {
                const id_peserta = $(this).data('id');
                let reader = new FileReader();
                reader.onload = (e) => {
                    $(`#preview-img-${i}-${id_peserta}`).attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });
        }

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
