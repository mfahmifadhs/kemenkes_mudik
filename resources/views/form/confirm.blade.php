@extends('form.layout.app')

@section('content')
<style>
    .ticket-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border: none;
    }

    .ticket-header {
        background: #f8f9fa;
        padding: 30px;
        border-bottom: 2px dashed #e9ecef;
        position: relative;
    }

    /* Efek sobekan tiket di samping */
    .ticket-header::before,
    .ticket-header::after {
        content: '';
        position: absolute;
        bottom: -10px;
        width: 20px;
        height: 20px;
        background: #000;
        /* Sesuai background hero */
        border-radius: 50%;
    }

    .ticket-header::before {
        left: -10px;
    }

    .ticket-header::after {
        right: -10px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: bold;
        display: inline-block;
        font-size: 0.65rem;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-success {
        background: #d4edda;
        color: #155724;
    }

    .status-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 2px;
    }

    .info-value {
        color: #2d3436;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .table-modern thead {
        background: #f8f9fa;
    }

    .table-modern th {
        border: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #6c757d;
    }

    .btn-action {
        border-radius: 10px;
        padding: 12px 25px;
        transition: all 0.3s;
        font-weight: 600;
    }

    .btn-print {
        background: #2d3436;
        color: white;
    }

    .btn-print:hover {
        background: #000;
        color: white;
        transform: translateY(-2px);
    }
</style>

<section class="hero-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="text-white font-weight-bold">Mudik Bersama Kemenkes 2025</h1>
            <p class="text-white-50">Detail Konfirmasi Pendaftaran</p>
        </div>

        <div class="col-lg-8 mx-auto">
            <div class="ticket-card">
                <div class="ticket-header p-4">
                    <div class="row align-items-center">
                        <div class="col-6 col-md-4 mb-3 mb-md-0">
                            <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="140" class="img-fluid">
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="d-flex flex-column flex-md-row justify-content-md-end align-items-md-center gap-3">

                                <div class="text-md-right me-md-4 mb-3 mb-md-0">
                                    <div class="info-label small text-muted text-uppercase fw-bold mb-1">Status Verifikasi</div>
                                    @if ($book->approval_uker == 'false' || $book->approval_roum == 'false')
                                    <span class="badge rounded-pill bg-danger px-3 py-2">Ditolak</span>
                                    @elseif ($book->approval_uker == 'true' && $book->approval_roum == 'true')
                                    <span class="badge rounded-pill bg-success px-3 py-2">Terverifikasi</span>
                                    @else
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Proses Verifikasi</span>
                                    @endif
                                </div>

                                @if (!$book->payment_status || $book->payment_status == 'proses' || $book->payment_status == 'ditolak')
                                <div class="text-md-right mt-3">
                                    <div class="info-label small text-muted text-uppercase fw-bold mb-1">Batas Waktu Deposit</div>
                                    <h3 id="countdown" class="text-primary font-weight-bold">
                                    </h3>

                                    <div class="mt-3">
                                        @if($book->payment_status == 'ditolak')
                                        <div class="badge badge-danger mb-2">Pembayaran Ditolak: Mohon Upload Ulang</div>
                                        @elseif($book->payment_status == 'proses')
                                        <div class="badge badge-warning mb-2">Pembayaran Sedang Diverifikasi</div>
                                        @endif

                                        <br>
                                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#modalUploadBukti">
                                            <i class="fas fa-upload mr-1"></i> Upload Bukti Transaksi
                                        </button>
                                    </div>
                                </div>
                                @else
                                <div class="text-md-right mt-3">
                                    <div class="badge badge-success p-2 px-3 rounded-pill">
                                        <i class="fas fa-check-circle mr-1"></i> Pembayaran Diterima
                                    </div>
                                </div>
                                @endif

                                @if($book->approval_uker == 'true' && $book->approval_roum == 'true')
                                <div class="text-md-right">
                                    <div class="info-label small text-muted text-uppercase fw-bold mb-1">Opsi Tiket</div>
                                    <a href="javascript:void(0)"
                                        onclick="handleDownload('<?php echo route('ticket.download', $book->id_booking); ?>')"
                                        class="badge rounded-pill bg-main px-3 py-2 shadow-sm d-flex align-items-center gap-2 px-3 py-2"
                                        style="border-radius: 8px;">
                                        <i class="fas fa-download"></i>
                                        <span>Download E-Tiket</span>
                                    </a>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 p-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Kode Booking</div>
                            <div class="info-value text-primary h4">#{{ $book->kode_booking }}</div>

                            <div class="info-label">Nama Pegawai</div>
                            <div class="info-value">{{ $book->nama_pegawai }}</div>

                            <div class="info-label">Unit Kerja</div>
                            <div class="info-value">{{ $book->uker->nama_unit_kerja }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Tujuan Perjalanan</div>
                            <div class="info-value">{{ $book->tujuan->nama_kota }}</div>

                            <div class="info-label">Rute Bus</div>
                            <div class="info-value text-muted" style="font-size: 0.9rem;">
                                {{ $book->rute->jurusan }}<br>
                                <small>{{ $book->rute->rute }}</small>
                            </div>
                        </div>
                    </div>

                    @if ($book->catatan)
                    <div class="alert alert-warning border-0 small mt-2">
                        <strong>Catatan:</strong> {{ $book->catatan }}
                    </div>
                    @endif

                    <hr class="my-4">

                    <h5 class="mb-3 font-weight-bold"><i class="fas fa-users mr-2 text-primary"></i>Daftar Penumpang</h5>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                    <th>NIK</th>
                                    <th>Bus/Kursi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($book->detail as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $row->nama_peserta }}</td>
                                    <td class="text-muted">{{ $row->nik }}</td>
                                    <td>
                                        <span class="badge badge-light border">Bus {{ $row->bus_id }}</span>
                                        <span class="badge badge-primary">Seat {{ $row->kode_seat }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-light p-3 rounded mt-4">
                        <h6 class="small font-weight-bold text-uppercase mb-2"><i class="fas fa-info-circle mr-1"></i> Informasi Penting</h6>
                        <ul class="small text-muted pl-3 mb-0">
                            <li>Simpan Kode Booking ini untuk pengecekan berkala.</li>
                            <li>E-Tiket otomatis dikirim ke email <strong>{{ $book->email }}</strong> setelah verifikasi akhir.</li>
                        </ul>
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        <a href="{{ url('/') }}" class="text-muted small font-weight-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                        </a>
                        <div>
                            @if ($book->approval_uker == 'true' && $book->approval_roum == 'true')
                            <a href="#" onclick="confirmLink(event, `{{ route('tiket', ['rand' => 'tiket', 'id' => $book->id_booking]) }}`)" class="btn btn-print btn-action shadow-sm">
                                <i class="fas fa-ticket-alt mr-2"></i> Cetak Tiket
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-white-50 mt-4 small">
                &copy; 2025 Biro Umum Kementerian Kesehatan RI
            </p>
        </div>
    </div>
</section>

<div class="modal fade" id="modalUploadBukti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title font-weight-bold">Upload Bukti Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('payment.upload', $book->id_booking) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_booking" value="{{ $book->id_booking }}">
                <div class="modal-body p-4 text-left">
                    <div class="alert alert-info small">
                        Pastikan foto bukti transfer terlihat jelas (Nama pengirim, Nominal, dan Tanggal).
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small">PILIH FILE (JPG/PNG/PDF)</label>
                        <input type="file" name="bukti_pembayaran" class="form-control-file shadow-sm p-2 border rounded" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill shadow">Kirim Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    function handleDownload(url) {
        // 1. Tampilkan Loading SweetAlert
        Swal.fire({
            title: 'Sedang Memproses...',
            text: 'Mohon tunggu sebentar, tiket Anda sedang disiapkan.',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // 2. Gunakan Fetch untuk mengambil data file
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengunduh tiket');
                return response.blob(); // Ubah response menjadi Blob (Binary Large Object)
            })
            .then(blob => {
                // 3. Buat link sementara untuk memicu download di browser
                const urlBlob = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = urlBlob;
                a.download = "etiket_mudik.pdf"; // Nama file otomatis
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(urlBlob);

                // 4. Tutup SweetAlert dengan sukses
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Tiket Anda telah terunduh otomatis.',
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Waduh!',
                    text: 'Terjadi kesalahan: ' + error.message
                });
            });
    }
</script>

<script>
    // Ambil data limit dari server (format: YYYY-MM-DD HH:mm:ss)
    const paymentLimit = new Date("{{ $book->payment_limit }}").getTime();

    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = paymentLimit - now;

        // Hitung hari, jam, menit, dan detik
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilkan hasil di elemen id="countdown"
        const display = document.getElementById("countdown");

        if (distance > 0) {
            display.innerHTML = days + "h " + hours + "j " + minutes + "m " + seconds + "s ";
        } else {
            clearInterval(x);
            display.innerHTML = "WAKTU HABIS";
            display.classList.replace("text-primary", "text-danger");
        }
    }, 1000);
</script>
@endsection
@endsection
