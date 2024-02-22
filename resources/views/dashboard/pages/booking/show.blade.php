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
                            <div class="form-group col-md-3">
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
                                <label class="col-form-label text-xs">Status</label>
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Seluruh Status</option>
                                    <option value="verif_uker" <?php echo $status == 'verif_uker' ? 'selected' : ''; ?>>
                                        Verifikasi Unit Kerja
                                    </option>
                                    <option value="verif_roum" <?php echo $status == 'verif_roum' ? 'selected' : ''; ?>>
                                        Verifikasi Biro Umum
                                    </option>
                                    <option value="succeed" <?php echo $status == 'succeed' ? 'selected' : ''; ?>>
                                        Selesai Verifikasi
                                    </option>
                                    <option value="rejected" <?php echo $status == 'rejected' ? 'selected' : ''; ?>>
                                        Tidak Disetujui
                                    </option>
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
                                    <th style="width: 12%;">Unit Kerja</th>
                                    <th style="width: 27%;">Nama Pegawai</th>
                                    <th style="width: 23%;">Tujuan</th>
                                    <th style="width: 5%;">Peserta</th>
                                    <th style="width: 8%;">Status</th>
                                    <th style="width: 8%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($book as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                    <td class="text-left">
                                        @if ($row->approval_uker || !$row->approval_uker)
                                        @php $status = !$row->approval_uker ? 'text-warning' : ($row->approval_uker == 'true' ? 'text-success' : 'text-danger'); @endphp
                                        <label class="mb-1 btn-xs border-dark text-xs {{ $status }}">
                                            <span class="text-xs">
                                                @if (!$row->approval_uker)
                                                <i class="fas fa-clock"></i>
                                                @elseif ($row->approval_uker == 'true')
                                                <i class="fas fa-check-circle"></i>
                                                @elseif ($row->approval_uker == 'false')
                                                <i class="fas fa-times-circle"></i>
                                                @endif
                                                Unit Kerja
                                            </span>
                                        </label>
                                        @endif
                                        @if ($row->approval_roum || !$row->approval_roum)
                                        @php $status = !$row->approval_roum ? 'text-warning' : ($row->approval_roum == 'true' ? 'text-success' : 'text-danger'); @endphp
                                        <label class="mb-1 btn-xs border-dark text-xs {{ $row->approval_uker == 'false' ? 'text-danger' : $status }}">
                                            <span class="text-xs">
                                                @if (!$row->approval_roum || !$row->approval_uker)
                                                <i class="fas fa-clock"></i>
                                                @elseif ($row->approval_roum == 'true')
                                                <i class="fas fa-check-circle"></i>
                                                @elseif ($row->approval_roum == 'false' || $row->approval_uker == 'false')
                                                <i class="fas fa-times-circle"></i>
                                                @endif
                                                Biro Umum
                                            </span>
                                        </label>
                                        @endif
                                        @if ($row->catatan)
                                        <label class="mb-1 btn-xs border-dark text-danger" style="font-size: 9px;">
                                            {{ $row->catatan }}
                                        </label>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('book.validation', $row->id_booking) }}" class="btn btn-default btn-small border-dark">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                        @if (Auth::user()->role_id == 1 || Auth::user()->uker_id == $row->uker_id && Auth::user()->role_id == 4)
                                        <a href="{{ route('book.edit', $row->id_booking) }}" class="btn btn-default btn-small border-dark mt-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @endif
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
