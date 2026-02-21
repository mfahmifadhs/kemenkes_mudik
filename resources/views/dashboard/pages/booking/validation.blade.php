@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0"> Detail Boking <small>({{ $book->kode_booking }})</small></h5>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('dashboard') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <center>
                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                    <div class="timeline-step">
                        <div class="timeline-content">
                            @if (!$book->approval_uker)
                            <i class="fas fa-dot-circle fa-2x text-danger"></i>
                            @else
                            <i class="fas fa-dot-circle fa-2x text-success"></i>
                            @endif
                            <p class="text-muted mb-0 mb-lg-0 mt-2">
                                Verifikasi Unit Kerja
                            </p>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-content">
                            @if (!$book->approval_roum)
                            <i class="fas fa-dot-circle fa-2x text-danger"></i>
                            @else
                            <i class="fas fa-dot-circle fa-2x text-success"></i>
                            @endif

                            <p class="text-muted mb-0 mb-lg-0 mt-2">
                                Verifikasi Biro Umum
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-left text-sm">
                        <label>Rincian Pegawai</label>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row ml-3 my-2">
                                    <div class="col-md-2">Kode Boking</div>
                                    <div class="col-md-9">: {{ $book->kode_booking }}</div>
                                    <div class="col-md-2">Nama Pegawai</div>
                                    <div class="col-md-9">: {{ $book->nama_pegawai }}</div>
                                    <div class="col-md-2">NIK/NIP</div>
                                    <div class="col-md-9">: {{ $book->nip_nik }}</div>
                                    <div class="col-md-2">No. Telp</div>
                                    <div class="col-md-9">: {{ $book->no_telp }}</div>
                                    <div class="col-md-2">Alamat</div>
                                    <div class="col-md-9">: {{ $book->alamat }}</div>
                                    <div class="col-md-2">Email</div>
                                    <div class="col-md-9">: {{ $book->email }}</div>
                                    <div class="col-md-2">Unit Kerja</div>
                                    <div class="col-md-9">: {{ $book->uker->nama_unit_kerja }}</div>
                                    @if($book->nama_upt)
                                    <div class="col-md-2">Nama UPT</div>
                                    <div class="col-md-9">: {{ $book->nama_upt }}</div>
                                    @endif
                                    <div class="col-md-2">Foto KTP</div>
                                    <div class="col-md-9">:
                                        @if ($book->foto_ktp)
                                        <a class="text-primary" href="#" data-toggle="modal" data-target="#ktp">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </div>
                                    <div class="col-md-2">Foto Kartu Keluarga</div>
                                    <div class="col-md-9">:
                                        @if ($book->foto_kk)
                                        <a class="text-primary" href="#" data-toggle="modal" data-target="#kk">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </div>
                                    <div class="col-md-2">Tujuan</div>
                                    <div class="col-md-9">: {{ $book->tujuan->nama_kota }}</div>
                                    <div class="col-md-2">Rute</div>
                                    <div class="col-md-9">:
                                        {{ ucwords(strtolower($book->rute->jurusan)) }} <br> <span class="ml-1">{{ $book->rute->rute }}</span>
                                    </div>

                                    <div class="col-md-2">Bukti Pembayaran</div>
                                    <div class="col-md-9">:
                                        @if($book->payment && $book->payment->first()->payment_method == 'transfer')
                                        @php
                                        $extension = pathinfo($book->payment_file, PATHINFO_EXTENSION);
                                        $filePath = asset('storage/' . $book->payment_file);
                                        @endphp

                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <a href="{{ $filePath }}" target="_blank">
                                            ({{ $book->payment->first()->payment_method }}) Lihat bukti pembayaran
                                        </a>
                                        @elseif(strtolower($extension) == 'pdf')
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger fa-3x mr-3"></i>
                                            <div>
                                                <span class="d-block mb-1">Dokumen Pembayaran (PDF)</span>
                                                <a href="{{ $filePath }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill">
                                                    <i class="fas fa-external-link-alt"></i> Buka PDF
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        <a type="button" data-toggle="modal" data-target="#editPembayaran">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="#" class="text-danger btn-xs" onclick="confirmLink(event, `{{ route('payment.delete', $book->id_booking) }}`)">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @elseif ($book->payment->first() && $book->payment->first()->payment_method == 'cash')
                                        ({{ $book->payment->first()->payment_method }}) &nbsp;
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Lunas</span>
                                        <a type="button" data-toggle="modal" data-target="#editPembayaran">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="#" class="text-danger btn-xs" onclick="confirmLink(event, `{{ route('payment.delete', $book->id_booking) }}`)">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @else
                                        <span class="text-muted italic">Belum melakukan pembayaran</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                @if (!$book->approval_uker && !$book->approval_roum)
                                <i class="fas fa-history text-warning fa-6x" style="opacity: 0.4;"></i>
                                @endif

                                @if ($book->approval_uker == 'true' && $book->approval_roum == 'true')
                                <i class="fas fa-check-circle text-success fa-6x" style="opacity: 0.4;"></i>
                                @endif

                                @if ($book->approval_uker == 'false' || $book->approval_roum == 'false')
                                <i class="fas fa-times-circle text-danger fa-6x mb-2" style="opacity: 0.4;"></i><br>
                                <span class="text-danger">{{ $book->catatan }}</span>
                                @endif
                            </div>
                        </div>

                        <label class="my-2">Rincian Peserta</label>
                        <table class="table table-bordered text-center ">
                            <thead>
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Aksi</th>
                                    <th class="align-middle">Nama Peserta</th>
                                    <th class="align-middle">Usia</th>
                                    <th class="align-middle">NIK</th>
                                    <th class="align-middle">Kode Seat</th>
                                    <th class="align-middle">Bus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($book->detail as $row)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if (Auth::user()->role_id != 4)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger btn-round shadow-sm"
                                            onclick="confirmDelete(event, `{{ route('peserta.delete', $row->id_peserta) }}`)"
                                            data-toggle="tooltip"
                                            title="Hapus Peserta">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif

                                        <a type="button"
                                            class="btn btn-sm btn-outline-warning btn-round shadow-sm"
                                            data-toggle="modal" data-target="#modalEdit-{{ $row->id_peserta }}"
                                            data-toggle="tooltip"
                                            title="Edit Peserta">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <div class="modal fade" id="modalEdit-{{ $row->id_peserta }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered shadow-lg" role="document">
                                                <div class="modal-content border-0 rounded-lg">

                                                    <div class="modal-header bg-light border-0 py-3">
                                                        <h5 class="modal-title font-weight-bold text-primary" id="modalLabel">
                                                            <i class="fas fa-user-plus mr-2"></i>Edit Peserta Baru
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" class="text-danger">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form id="form-edit-{{ $row->id_peserta }}" action="{{ route('peserta.update', $row->id_peserta) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body p-4">
                                                            <input type="hidden" name="id" value="{{ $book->id_booking }}">

                                                            <div class="form-group">
                                                                <label class="small font-weight-bold text-muted">NAMA LENGKAP</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="nama" class="form-control rounded-right shadow-sm" value="{{ $row->nama_peserta }}" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-7 form-group">
                                                                    <label class="small font-weight-bold text-muted">NIK</label>
                                                                    <input type="number" name="nik" class="form-control rounded shadow-sm" value="{{ $row->nik }}" required>
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <label class="small font-weight-bold text-muted">USIA</label>
                                                                    <div class="input-group">
                                                                        <input type="number" name="usia" class="form-control rounded shadow-sm" value="{{ $row->usia }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-7 form-group">
                                                                    <label class="small font-weight-bold text-muted text-uppercase">Pilih Bus</label>
                                                                    <select name="bus" id="select-bus" class="form-control rounded shadow-sm custom-select" required>
                                                                        <option value="">-- Pilih Bus --</option>
                                                                        @foreach($bus as $b)
                                                                        <option value="{{ $b->id_bus }}" <?= $b->id_bus == $row->bus_id ? 'selected' : ''; ?>>
                                                                            {{ $b->no_bus }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-5 form-group">
                                                                    <label class="small font-weight-bold text-muted">Pilih Seat</label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="seat" class="form-control rounded shadow-sm" value="{{ $row->kode_seat }}" maxlength="3" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer bg-light border-0 p-3">
                                                            <button type="button" class="btn btn-link text-muted font-weight-bold" data-dismiss="modal">Batal</button>
                                                            <button type="button" id="btnSimpanPeserta" onclick="confirmSubmit(event, `form-edit-{{ $row->id_peserta }}`)" class="btn btn-primary px-4 rounded-pill shadow">
                                                                <i class="fas fa-save mr-1"></i> Simpan Data
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $row->nama_peserta }}</td>
                                    <td>{{ (int) $row->usia.' Tahun' }}</td>
                                    <td>{{ $row->nik }}</td>
                                    <td>{{ $row->kode_seat }}</td>
                                    <td>{{ $row->bus_id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ((!$book->status && !$book->approval_uker && Auth::user()->role_id == 4) && $book->payment_status == 'true')
                    @if ($book->uker->unit_utama_id == '46593' && $book->uker_id == Auth::user()->uker_id)
                    <div class="card-footer text-right font-weight-bold">
                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#tolak">
                            <i class="fas fa-times-circle"></i> Tolak
                        </a>
                        <a href="{{ route('book.true', $book->id_booking) }}" class="btn btn-success" onclick="confirmTrue(event)">
                            <i class="fas fa-check-circle"></i> Setuju
                        </a>
                    </div>
                    @elseif (Auth::user()->uker->unit_utama_id == $book->uker->unit_utama_id)
                    <div class="card-footer text-right font-weight-bold">
                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#tolak">
                            <i class="fas fa-times-circle"></i> Tolak
                        </a>
                        <a href="{{ route('book.true', $book->id_booking) }}" class="btn btn-success" onclick="confirmTrue(event)">
                            <i class="fas fa-check-circle"></i> Setuju
                        </a>
                    </div>
                    @endif
                    @elseif (Auth::user()->role_id == 4 && !$book->payment_status)
                    <div class="card-footer text-right text-bold">
                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#modalPembayaran">
                            <i class="fas fa-hand-holding-usd"></i> Proses Pembayaran
                        </button>
                    </div>

                    <!-- Modal Tambah Pembayaran -->
                    <div class="modal fade" id="modalPembayaran" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalPembayaranLabel font-weight-bold">
                                        <i class="fas fa-wallet mr-2"></i> Konfirmasi Pembayaran
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('payment.store', $book->id_booking) }}" method="POST" enctype="multipart/form-data" id="formPembayaran">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label font-weight-bold">Metode Pembayaran</label>
                                            <select name="payment_method" id="metode_pembayaran" class="form-select custom-select" required>
                                                <option value="" selected disabled>-- Pilih Metode --</option>
                                                <option value="cash">💵 Tunai (Cash)</option>
                                                <option value="transfer">📱 Transfer Bank</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label font-weight-bold">Tanggal Pembayaran</label>
                                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <div id="input_transfer" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label class="form-label font-weight-bold">Upload Bukti Pembayaran</label>
                                                <div class="custom-file">
                                                    <input type="file" name="payment_file" class="form-control" id="bukti_pembayaran" accept="image/*">
                                                    <small class="text-muted">Format: JPG, PNG, PDF (Maks 2MB)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <label class="form-label font-weight-bold">Keterangan</label>
                                            <textarea name="payment_notes" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4" onclick="confirmSubmit(event, 'formPembayaran');">
                                            <i class="fas fa-check-circle mr-1"></i> Simpan Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="card-footer d-flex justify-content-end align-items-center flex-wrap" style="gap: 8px;">

                        @if (Auth::user()->role_id != 4)
                        <button type="button" class="btn btn-outline-primary btn-sm shadow-sm px-3 rounded-pill" data-toggle="modal" data-target="#modalTambahPeserta">
                            <i class="fas fa-plus-circle mr-1"></i> <b>Tambah Peserta</b>
                        </button>
                        @endif

                        {{-- Kondisi untuk Tombol Kirim Email --}}
                        @if ($book->status == 'true')
                        <a id="download" class="btn btn-success btn-sm shadow-sm px-3" data-url="{{ route('tiket.cetak', $book->id_booking) }}" target="_blank">
                            <i class="fas fa-paper-plane mr-1"></i> <b>Kirim Email</b>
                        </a>
                        @endif

                        {{-- Kondisi untuk Tombol Setuju/Tolak --}}
                        @if (Auth::user()->role_id == 2 && !$book->approval_roum && $book->approval_uker == 'true')
                        <div class="btn-group shadow-sm" role="group">
                            <a class="btn btn-outline-danger btn-sm shadow-sm px-3 rounded-pill" href="#" data-toggle="modal" data-target="#tolak">
                                <i class="fas fa-times-circle mr-1"></i> Tolak
                            </a>
                        </div>
                        <div class="btn-group shadow-sm" role="group">
                            <a href="{{ route('book.true', $book->id_booking) }}" class="btn btn-outline-success btn-sm shadow-sm px-3 rounded-pill" onclick="confirmTrue(event)">
                                <i class="fas fa-check-circle mr-1"></i> Setuju
                            </a>
                        </div>
                        @endif


                        @if ($book->approval_roum == 'true' && Auth::user()->role_id == 2 || Auth::user()->role_id == 1)
                        <a id="download" class="btn btn-outline-success rounded-pill btn-sm" data-url="{{ route('tiket.email', $book->id_booking) }}" target="_blank">
                            <i class="fas fa-paper-plane"></i> <b>Kirm Email</b>
                        </a>
                        @endif

                    </div>
                </div>
            </center>
        </div>
    </div><br>
</div>

<div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered shadow-lg" role="document">
        <div class="modal-content border-0 rounded-lg">

            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-primary" id="modalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Peserta Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            <form id="formTambahPeserta" action="{{ route('peserta.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="id" value="{{ $book->id_booking }}">

                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">NAMA LENGKAP</label>
                        <div class="input-group">
                            <input type="text" name="nama" class="form-control rounded-right shadow-sm" placeholder="Contoh: John Doe" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7 form-group">
                            <label class="small font-weight-bold text-muted">NIK</label>
                            <input type="number" name="nik" class="form-control rounded shadow-sm" placeholder="16 Digit NIK" required>
                        </div>
                        <div class="col-md-5 form-group">
                            <label class="small font-weight-bold text-muted">USIA</label>
                            <div class="input-group">
                                <input type="number" name="usia" class="form-control rounded shadow-sm" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7 form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Pilih Bus</label>
                            <select name="bus" id="select-bus" class="form-control rounded shadow-sm custom-select" required>
                                <option value="">-- Pilih Bus --</option>
                                @foreach($bus as $b)
                                <option value="{{ $b->id_bus }}">{{ $b->no_bus }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5 form-group">
                            <label class="small font-weight-bold text-muted">Pilih Seat</label>
                            <div class="input-group">
                                <input type="text" name="seat" class="form-control rounded shadow-sm" placeholder="Contoh : 1A/2B/3C" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 p-3">
                    <button type="button" class="btn btn-link text-muted font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSimpanPeserta" onclick="confirmSubmit(event, 'formTambahPeserta')" class="btn btn-primary px-4 rounded-pill shadow">
                        <i class="fas fa-save mr-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolak" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Alasan Penolakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('book.false', $book->id_booking) }}" method="POST">
                @csrf
                <input type="hidden" name="tolak" value="true">
                <div class="modal-body">
                    <p>Alasan Penolakkan Peserta</p>
                    <textarea name="catatan" class="form-control" cols="10" rows="5" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default border-dark" onclick="confirmFalse(event, this)">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal KTP -->
<div class="modal fade" id="ktp" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/foto_ktp/'. $book->foto_ktp) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Modal KK -->
<div class="modal fade" id="kk" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Kartu Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/foto_kk/'. $book->foto_kk) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pembayaran -->
<div class="modal fade" id="editPembayaran" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-primary" id="modalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>

            @if($book->payment->first())
            <form action="{{ route('payment.update', $book->payment->first()->id) }}" method="POST" enctype="multipart/form-data" id="formEditPembayaran">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Metode Pembayaran</label>
                        <select name="payment_method" id="edit_metode_pembayaran" class="form-select custom-select" required>
                            <option value="cash" {{ $book->payment->first()->payment_method == 'cash' ? 'selected' : '' }}>
                                💵 Tunai (Cash)
                            </option>
                            <option value="transfer" {{ $book->payment->first()->payment_method == 'transfer' ? 'selected' : '' }}>
                                📱 Transfer Bank
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Tanggal Pembayaran</label>
                        <input type="date" name="payment_date" class="form-control"
                            value="{{ $book->payment->first()->payment_date }}" required>
                    </div>

                    <div id="edit_input_transfer">
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold">Upload Bukti Baru (Opsional)</label>
                            <input type="file" name="payment_file" class="form-control" id="edit_bukti_pembayaran" accept="image/*,application/pdf">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah bukti lama.</small>

                            @if($book->payment->first()->payment_method == 'transfer' && $book->payment->first()->payment_file)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $book->payment->first()->payment_file) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-paperclip"></i> Bukti saat ini sudah ada
                                    </small>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label font-weight-bold">Keterangan</label>
                        <textarea name="payment_notes" class="form-control" rows="3">{{ $book->payment->first()->payment_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" onclick="confirmSubmit(event, 'formEditPembayaran')">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@section('js')
<script>
    function openModal(key, idPeserta) {
        const modalId = `#vaksin${key}${idPeserta}`;
        console.log(modalId)
        $(modalId).modal('show');
    }

    function confirmTrue(event) {
        event.preventDefault();

        const url = event.currentTarget.href;

        Swal.fire({
            title: 'Setuju',
            text: 'Apakah peserta ini disetujui ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
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

                window.location.href = url;
            }
        });
    }

    function confirmFalse(event, button) {
        event.preventDefault();
        var form = $(button).closest('form');

        Swal.fire({
            title: 'Tolak',
            text: 'Apakah peserta ini ditolak?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
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

                form.submit();
            }
        });
    }
</script>

<script>
    document.getElementById('download').addEventListener('click', function(event) {
        event.preventDefault();
        const url = event.currentTarget.dataset.url;

        Swal.fire({
            title: 'Sedang Mengirim...',
            allowOutsideClick: true,
            showConfirmButton: false,
            timer: 9000,
            onBeforeOpen: () => {
                Swal.showLoading();
                window.location.href = url;
            },
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#select-bus').on('change', function() {
            var busId = $(this).val();
            var seatDropdown = $('#select-seat');
            var loading = $('#loading-seat');

            if (busId) {
                // Aktifkan loading, kosongkan seat
                seatDropdown.empty().append('<option value="">-- Pilih Seat --</option>');
                seatDropdown.prop('disabled', true);
                loading.removeClass('d-none');

                // Panggil API/Route untuk ambil seat
                $.ajax({
                    url: '/get-seats/' + busId, // Sesuaikan dengan route Anda
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        loading.addClass('d-none');
                        seatDropdown.prop('disabled', false);

                        $.each(data, function(key, value) {
                            // Hanya tampilkan seat yang statusnya 'true' (tersedia)
                            if (value.status == 'true') {
                                seatDropdown.append('<option value="' + value.kode_seat + '">' + value.kode_seat + '</option>');
                            }
                        });
                    }
                });
            } else {
                seatDropdown.prop('disabled', true);
            }
        });
    });
</script>

<script>
    function confirmDelete(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus Peserta?',
            text: "Data ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b', // Warna merah ala Bootstrap Danger
            cancelButtonColor: '#858796', // Warna abu-abu ala Secondary
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Animasi Loading Modern
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menghapus data.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Redirect ke route delete
                window.location.href = url;
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#metode_pembayaran').on('change', function() {
            const metode = $(this).val();

            if (metode === 'transfer') {
                $('#input_transfer').slideDown(400); // Efek smooth terbuka
                $('#bukti_pembayaran').attr('required', true);
            } else {
                $('#input_transfer').slideUp(400); // Efek smooth tertutup
                $('#bukti_pembayaran').attr('required', false);
            }
        });
    });
</script>
@endsection
@endsection