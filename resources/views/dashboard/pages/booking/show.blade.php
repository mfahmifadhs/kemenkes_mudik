@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <small>Daftar Peserta</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Daftar Peserta</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right mt-4">
                    <a id="downloadButton" onclick="downloadFile('excel')" class="btn btn-csv bg-success border-success" target="__blank">
                        <span class="btn btn-success btn-sm"><i class="fas fa-download"></i></span>
                        <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <small>Download Excel</small>
                    </a>
                    <a id="downloadButton" onclick="downloadFile('pdf')" class="btn btn-csv bg-danger border-danger" target="__blank">
                        <span class="btn btn-danger btn-sm"><i class="fas fa-print"></i></span>
                        <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <small>Cetak</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card w-100">
                <div class="card-header">
                    <label>Tabel Daftar Peserta</label>
                    <form id="form" action="{{ route('peserta.filter') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label text-xs">Unit Utama</label>
                                <select name="utama" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Unit Utama</option>
                                    @foreach ($dataUtama as $row)
                                    <option value="{{ $row->id_unit_utama }}" <?php echo $row->id_unit_utama == $utama ? 'selected' : '' ?>>
                                        {{ $row->nama_unit_utama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="col-form-label text-xs">Unit Kerja</label>
                                <select name="uker" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Unit Kerja</option>
                                    @foreach ($dataUker as $row)
                                    <option value="{{ $row->id_unit_kerja }}" <?php echo $row->id_unit_kerja == $uker ? 'selected' : '' ?>>
                                        {{ $row->nama_unit_kerja }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label text-xs">Trayek</label>
                                <select name="rute" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Trayek</option>
                                    @foreach ($dataRute as $row)
                                    <option value="{{ $row->id_trayek }}" <?php echo $row->id_trayek == $rute ? 'selected' : '' ?>>
                                        {{ $loop->iteration.'. '.$row->jurusan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label text-xs">Tujuan</label>
                                <select name="tujuan" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Tujuan</option>
                                    @foreach ($dataTujuan as $row)
                                    <option value="{{ $row->id_detail }}" <?php echo $row->id_detail == $tujuan ? 'selected' : '' ?>>
                                        {{ $row->nama_kota }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label text-xs">Bus</label>
                                <select name="tanggal" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Bus</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header">
                    <div class="">
                        <table id="table" class="table table-bordered text-center">
                            <thead class="text-sm">
                                <tr>
                                    <th style="width: 0%;">No</th>
                                    <th style="width: 5%;">Tanggal</th>
                                    <th style="width: 15%;">Unit Kerja</th>
                                    <th style="width: 27%;">Nama Pegawai</th>
                                    <th style="width: 23%;">Tujuan</th>
                                    <th style="width: 5%;">Peserta</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($book as $row)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                        @if ($row->status == 'true') <i class="fas fa-check-circle text-success"></i>@endif
                                        @if ($row->status == 'false') <i class="fas fa-times-circle text-danger"></i>@endif
                                        @if ($row->status == null) <i class="fas fa-clock text-warning"></i>@endif
                                    </td>
                                    <td>{{ $row->created_at }}</td>
                                    <td class="text-left">{{ $row->uker->nama_unit_kerja }}</td>
                                    <td class="text-left">
                                        <div class="row">
                                            <div class="col-md-3">Kode Boking</div>
                                            <div class="col-md-8">: {{ $row->kode_booking }}</div>
                                            <div class="col-md-3">Nama</div>
                                            <div class="col-md-8">: {{ $row->nama_pegawai }}</div>
                                            <div class="col-md-3">NIK/NIP</div>
                                            <div class="col-md-8">: {{ $row->nip_nik }}</div>
                                            <div class="col-md-3">No. Telp</div>
                                            <div class="col-md-8">: {{ $row->no_telp }}</div>
                                            <div class="col-md-3">Alamat</div>
                                            <div class="col-md-8">: {{ $row->alamat }}</div>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <div class="row">
                                            <div class="col-md-4">Tujuan</div>
                                            <div class="col-md-7">: {{ $row->tujuan->nama_kota }}</div>
                                            <div class="col-md-4">Jurusan</div>
                                            <div class="col-md-7">: {{ ucwords(strtolower($row->rute->jurusan)) }}</div>
                                            <div class="col-md-12 mt-2">Rute :</div>
                                            <div class="col-md-12">{{ $row->rute->rute }}</div>
                                        </div>
                                    </td>
                                    <td class="text-left align-middle text-center">
                                        {{ $row->detail->count() }} orang
                                    </td>
                                    <td>
                                        <a href="{{ route('book.validation', $row->id_booking) }}" class="btn btn-default btn-small border-dark">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

@section('js')
<script>
    $('[name="area"]').select2()

    function confirmRemove(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus ?',
            text: 'Hapus data tamu ini',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function downloadFile(downloadFile) {
        var form = document.getElementById('form');
        var downloadButton = document.getElementById('downloadButton');
        var downloadSpinner = document.getElementById('downloadSpinner');

        downloadSpinner.style.display = 'inline-block';

        var existingDownloadFile = form.querySelector('[name="downloadFile"]');
        if (existingDownloadFile) {
            existingDownloadFile.remove();
        }

        var downloadFileInput = document.createElement('input');
        downloadFileInput.type = 'hidden';
        downloadFileInput.name = 'downloadFile';
        downloadFileInput.value = downloadFile;
        form.appendChild(downloadFileInput);

        downloadButton.disabled = true;
        form.target = '_blank';

        form.submit();
        location.reload();
    }
</script>
@endsection
@endsection
