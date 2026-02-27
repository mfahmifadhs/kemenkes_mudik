@extends('dashboard.layout.app')

@section('content')

@if (Session::has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ Session::get("success") }}',
    });
</script>
@endif


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Halo, <small>{{ Auth::user()->name }}</small></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <h6 id="timestamp" class="mt-2"></h6>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">

                    <div class="card w-100">
                        <div class="card-header mt-2">
                            <div class="float-left">
                                <label>Tabel Peserta</label>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="">
                                <table id="table" class="table table-bordered text-center">
                                    <thead class="text-sm">
                                        <tr>
                                            <th style="width: 0%;">No</th>
                                            <th style="width: 15%;">Tanggal</th>
                                            <th style="width: 30%;">Pegawai</th>
                                            <th style="width: 25%;">Rute</th>
                                            <th style="width: 10%;">Tujuan</th>
                                            <th style="width: 10%;">Deposit</th>
                                            <th style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @foreach($book as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM Y') }}</span>
                                                    <small class="text-muted">{{ Carbon\Carbon::parse($row->created_at)->format('H:i:s') }}</small>
                                                </div>
                                            </td>
                                            <td class="text-left">

                                                <div class="d-flex flex-column gap-1">
                                                    <div>
                                                        <span class="text-danger text-xs fw-bold mb-1 ml-0">
                                                            <b>Batas Waktu Deposit : {{ Carbon\Carbon::parse($row->payment_limit)->isoFormat('DD MMM Y | HH:mm:ss') }}</b>
                                                        </span>
                                                    </div>
                                                    <div><span class="text-primary text-xs fw-bold mb-1 ml-0"><b>{{ $row->kode_booking }}</b></span></div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $row->nama_pegawai }}</div>
                                                    <div class="small">
                                                        <i class="fas fa-id-card me-1"></i> {{ $row->nip_nik }} |
                                                        <i class="fas fa-phone me-2"></i> {{ $row->no_telp }} |
                                                        <i class="fas fa-users me-1"></i> {{ $row->detail->count() }} orang
                                                    </div>
                                                    <div class="small italic">
                                                        <i class="fas fa-city me-1"></i> {{ $row->uker->nama_unit_kerja }}
                                                        @if($row->nama_upt) <br><span class="ms-3">— {{ $row->nama_upt }}</span> @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <h6 style="font-size: 0.9rem;" class="d-block text-bold">{{ $row->rute->jurusan }}</h5>
                                                <h6 style="font-size: 0.8rem;">{{ $row->rute->rute }}</h5>
                                            </td>
                                            <td>{{ strtoupper($row->tujuan->nama_kota) }}</td>
                                            <td>
                                                @php $payment = $row->payment->first(); @endphp

                                                @if($payment && $row->payment_status)
                                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 mb-2 text-capitalize">
                                                    <i class="bi bi-check-circle me-1"></i>Sudah Bayar {{ $payment->payment_method }}
                                                </span>
                                                <br>
                                                @if ($payment->payment_method == 'transfer')
                                                <a href="{{ asset('storage/' . $payment->payment_file) }}" target="_blank" class="btn btn-link btn-sm p-0 text-decoration-none">
                                                    <i class="bi bi-image me-1"></i>Lihat Bukti
                                                </a>
                                                @endif
                                                @else
                                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                                    <i class="bi bi-x-circle me-1"></i>Belum Bayar
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('book.validation', $row->id_booking) }}" class="btn btn-warning btn-xs border-dark text-xs">
                                                    <i class="fa-solid fa-file-signature fa-1x"></i>
                                                    <span class="text-xs">Validasi</span>
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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <table class="table text-sm">
                                @foreach ($rute as $row)
                                <tr>
                                    <td>
                                        {{ $loop->iteration}}. {{ $row->jurusan }} <br>
                                        <small>{{ $row->rute }}</small> <br>
                                        @foreach ($row->bus as $subRow)
                                        <a href="{{ route('bus.detail', $subRow->id_bus) }}" class="btn btn-default my-2">
                                            <i class="fas fa-bus fa-2x"></i>
                                            Bus {{ $subRow->id_bus }} <br>
                                            <span class="text-left text-xs">
                                                @php $seat = $subRow->total_kursi - $subRow->detail->where('status', '!=', 'cancel')->count(); @endphp
                                                @if ($seat == 0) <span class="text-danger">Penuh</span>
                                                @else <span class="text-success">Tersedia <b>{{ $seat }}</b> seat</span> @endif
                                            </span>
                                        </a>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

@section('js')
<script>
    function confirmLink(event, url, title, text) {
        event.preventDefault();

        Swal.fire({
            title: title,
            text: text,
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
</script>
@endsection

@endsection
