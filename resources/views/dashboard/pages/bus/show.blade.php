@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <small>Daftar Bus</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Daftar Bus</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right mt-4">
                    <a href="{{ route('bus.export', 'excel') }}" class="btn btn-csv bg-success border-success" target="__blank">
                        <span class="btn btn-success btn-sm"><i class="fas fa-download"></i></span>
                        <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                        <small>Download Excel</small>
                    </a>
                    <a href="{{ route('bus.pdfSeat') }}" class="btn btn-csv bg-danger border-danger" target="__blank">
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
                    <label>Tabel Daftar Bus</label>
                </div>
                <div class="card-header">
                    <div class="">
                        <table id="table" class="table table-bordered text-center">
                            <thead class="text-sm">
                                <tr>
                                    <th>No</th>
                                    <th>No. Mobil</th>
                                    <th>Merk Tipe</th>
                                    <th>Jurusan</th>
                                    <th style="width: 20%;">Rute</th>
                                    <th>Total Kursi</th>
                                    <th>Total Tersedia</th>
                                    <th>Total Dipesan</th>
                                    <th>Total Terisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($bus as $row)
                                <tr>
                                    <td>
                                        @if ($row->status == 'true') <i class="fas fa-check-circle text-success"></i> @endif
                                        @if ($row->status == 'false') <i class="fas fa-times-circle text-danger"></i> @endif
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $row->no_plat }}</td>
                                    <td class="text-left">{{ $row->deskripsi }}</td>
                                    <td>{{ $row->trayek->jurusan }}</td>
                                    <td class="text-left">{{ $row->trayek->rute }}</td>
                                    <td>{{ $row->total_kursi }}</td>
                                    <td>{{ $row->total_kursi - $row->detail->where('status', '!=', 'cancel')->count() }}</td>
                                    <td>{{ $row->detail->where('status', 'book')->count() }}</td>
                                    <td>{{ $row->detail->where('status', 'full')->count() }}</td>
                                    <td>
                                        <a href="{{ route('bus.detail', $row->id_bus) }}" class="btn btn-default btn-small border-dark">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                        <a href="#" class="btn btn-default btn-small border-dark" data-toggle="modal" data-target="#editBus{{ $row->id_bus }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <div class="modal fade" id="editBus{{ $row->id_bus }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered shadow-lg" role="document">
                                                <div class="modal-content border-0 rounded-lg">

                                                    <div class="modal-header bg-light border-0 py-3">
                                                        <h5 class="modal-title font-weight-bold text-primary" id="modalLabel">
                                                            <i class="fas fa-user-plus mr-2"></i>Edit Data Bus
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" class="text-danger">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form id="formEditBus-{{ $row->id_bus }}" action="{{ route('bus.update', $row->id_bus) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <input type="hidden" name="id" value="{{ $row->id_bus }}">
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted text-uppercase">Pilih Trayek</label>
                                                                    <select name="trayek" class="form-control rounded shadow-sm custom-select" required>
                                                                        <option value="">-- Pilih Trayek --</option>
                                                                        @foreach($trayek as $t)
                                                                        <option value="{{ $t->id_trayek }}" {{ $t->id_trayek == $row->trayek_id ? 'selected' : '' }}>
                                                                            {{ $t->jurusan }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted">No. Plat</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="no_plat" class="form-control rounded shadow-sm" value="{{ $row->no_plat }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted">Merk/Tipe</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="deskripsi" class="form-control rounded shadow-sm" value="{{ $row->deskripsi }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted">Total Kursi</label>
                                                                    <div class="input-group">
                                                                        <input type="number" name="total_kursi" class="form-control rounded shadow-sm" value="{{ $row->total_kursi }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted">Seat Kiri</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="seat_kiri" class="form-control rounded shadow-sm" value="{{ $row->seat_kiri }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted">Seat Kanan</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="seat_kanan" class="form-control rounded shadow-sm" value="{{ $row->seat_kanan }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted">Seat Belakang</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="seat_belakang" class="form-control rounded shadow-sm" value="{{ $row->seat_belakang }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted">Kode Seat Kiri</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="kode_seat_kiri" class="form-control rounded shadow-sm" value="{{ $row->kd_seat_kiri }}">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 form-group">
                                                                    <label class="small font-weight-bold text-muted">Kode Seat Kanan</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="kode_seat_kanan" class="form-control rounded shadow-sm" value="{{ $row->kd_seat_kanan }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted">Kode Seat Belakang</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="kode_seat_belakang" class="form-control rounded shadow-sm" value="{{ $row->kd_seat_belakang }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted">Keterangan</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="keterangan" class="form-control rounded shadow-sm" value="{{ $row->keterangan }}">
                                                                    </div>
                                                                </div>

                                                                
                                                                <div class="col-md-12 form-group">
                                                                    <label class="small font-weight-bold text-muted text-uppercase">Status</label>
                                                                    <select name="status" class="form-control rounded shadow-sm custom-select" required>
                                                                        <option value="">-- Pilih Status --</option>
                                                                        <option value="true" {{ $row->status == 'true' ? 'selected' : '' }}>Aktif</option>
                                                                        <option value="false" {{ $row->status == 'false' ? 'selected' : '' }}>Tidak Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer bg-light border-0 p-3">
                                                            <button type="button" class="btn btn-link text-muted font-weight-bold" data-dismiss="modal">Batal</button>
                                                            <button type="button" id="btnSimpanBus" onclick="confirmSubmit(event, 'formEditBus-{{ $row->id_bus }}')" class="btn btn-primary px-4 rounded-pill shadow">
                                                                <i class="fas fa-save mr-1"></i> Simpan Data
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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