@extends('dashboard.layout.app')

@section('content')

<style>
    .bus-container {
        background: #f4f6f9;
        border-radius: 20px;
        padding: 20px;
        border: 5px solid #dee2e6;
        max-width: 550px;
        margin: 0 auto;
    }

    .seat-item {
        width: 100%;
        aspect-ratio: 1/0.5;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: bold;
        font-size: 0.8rem;
        cursor: default;
        transition: all 0.2s;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .seat-available {
        background-color: #10b981;
        color: white;
        box-shadow: 0 4px 0 #059669;
    }

    .seat-booked {
        background-color: #f59e0b;
        color: white;
        box-shadow: 0 4px 0 #d97706;
    }

    .seat-full {
        background-color: #f43f5e;
        color: white;
        box-shadow: 0 4px 0 #e11d48;
    }

    .seat-special {
        background-color: #64748b;
        color: white;
        box-shadow: 0 4px 0 #475569;
    }

    .driver-section {
        border-bottom: 2px dashed #cbd5e1;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .aisle {
        width: 100%;
        height: 100%;
    }

    .legend-box {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        display: inline-block;
        margin-right: 5px;
    }
</style>

<div class="content-wrapper bg-white">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-sm-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mb-1">
                            <li class="breadcrumb-item"><a href="#">Bus</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                    <h1 class="font-weight-bold text-dark">Bus {{ $bus->first()->id_bus }}
                        <span class="badge badge-primary-subtle text-primary ml-2" style="font-size: 1rem;">{{ $bus->first()->trayek->jurusan }}</span>
                    </h1>
                    <p class="text-muted"><i class="fas fa-route mr-1"></i> {{ $bus->first()->trayek->rute }}</p>
                </div>
                <div class="col-sm-4 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-dark rounded-pill px-4 shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-0 pt-4">
                            <h5 class="card-title font-weight-bold">Seat Plan</h5>
                            <div class="mt-3 d-flex flex-wrap gap-2" style="gap: 10px;">
                                <span>
                                    <div class="legend-box seat-available"></div><small>Tersedia</small>
                                </span>
                                <span>
                                    <div class="legend-box seat-booked"></div><small>Booking</small>
                                </span>
                                <span>
                                    <div class="legend-box seat-full"></div><small>Valid</small>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="bus-container">
                                <div class="row driver-section">
                                    <div class="col-5">
                                        <div class="seat-special mb-3 text-center p-2 rounded-pill">CO-DRV</div>
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="col-5">
                                        <div class="seat-special mb-3 text-center p-2 rounded-pill">
                                            <i class="fas fa-steering-wheel"></i> DRV
                                        </div>
                                    </div>
                                </div>

                                @foreach ($bus as $row)
                                @php $busId = $row->id_bus; @endphp
                                <div class="row">
                                    <div class="col-5">
                                        <div class="row">
                                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                                @foreach (json_decode($row->kd_seat_kiri, true) as $kode)
                                                @php
                                                $seatCode = $i . $kode . $busId;
                                                $statusClass = 'seat-available';
                                                if($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty()) $statusClass = 'seat-booked';
                                                if($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty()) $statusClass = 'seat-full';
                                                @endphp
                                                <div class="col-6 mb-3">
                                                    <div class="seat-item {{ $statusClass }}">{{ $i . $kode }}</div>
                                                </div>
                                                @endforeach
                                                @endfor
                                        </div>
                                    </div>

                                    <div class="col-2"></div>

                                    <div class="col-5">
                                        <div class="row">
                                            @for ($i = 1; $i <= $row->seat_kanan; $i++)
                                                @foreach (json_decode($row->kd_seat_kanan, true) as $kode)
                                                @php
                                                $seatCode = $i . $kode . $busId;
                                                $statusClass = 'seat-available';
                                                if($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty()) $statusClass = 'seat-booked';
                                                if($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty()) $statusClass = 'seat-full';
                                                @endphp
                                                <div class="col-6 mb-3">
                                                    <div class="seat-item {{ $statusClass }}">{{ $i . $kode }}</div>
                                                </div>
                                                @endforeach
                                                @endfor
                                        </div>
                                    </div>
                                </div>

                                @if ($row->total_kursi == 50 || $row->total_kursi == 46)
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <div class="seat-special text-center p-2 rounded-pill text-dark" style="background-color: #e9ecef; font-size: 0.8rem;">TOILET</div>
                                    </div>

                                    <div class="col-9">
                                        <div class="row">
                                            @foreach (json_decode($row->kd_seat_belakang, true) as $kode)
                                            @php
                                            $seatCode = "13" . $kode . $busId;
                                            $statusClass = 'seat-available';

                                            if($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty()) $statusClass = 'seat-booked';
                                            if($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty()) $statusClass = 'seat-full';
                                            @endphp

                                            <div class="col-3 mb-2">
                                                <div class="seat-item {{ $statusClass }} text-center">
                                                    13{{ $kode }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body p-0">
                            <div class="table-responsive p-4">
                                <table id="table-download" class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit Kerja</th>
                                            <th>ID Booking</th>
                                            <th>Nama Peserta</th>
                                            <th>Info</th>
                                            <th>Kursi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $shownBookings = []; @endphp
                                        @foreach ($peserta as $row)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                                <div class="mt-1">
                                                    @if ($row->status == 'cancel') <i class="fas fa-times-circle text-danger" title="Cancel"></i> @endif
                                                    @if ($row->status == 'book') <i class="fas fa-clock text-warning" title="Pending"></i> @endif
                                                    @if ($row->status == 'full') <i class="fas fa-check-circle text-success" title="Valid"></i> @endif
                                                </div>
                                            </td>
                                            <td style="font-size: 0.85rem;">
                                                <span class="font-weight-bold text-dark">{{ $row->booking->uker->nama_unit_kerja ?? '' }}</span>
                                            </td>
                                            <td><code class="text-primary font-weight-bold">{{ $row->booking->kode_booking }}</code></td>
                                            <td>
                                                <div class="font-weight-bold text-dark">{{ $row->nama_peserta }}</div>
                                                <small class="text-muted">NIK: {{ $row->nik }}</small>
                                            </td>
                                            <td>
                                                <div class="small">
                                                    <i class="fas fa-phone-alt mr-1 text-xs"></i> {{ !in_array($row->booking_id, $shownBookings) ? $row->booking->no_telp : '-' }}<br>
                                                    <i class="fas fa-birthday-cake mr-1 text-xs"></i> {{ $row->usia }} Thn
                                                </div>
                                                @php $shownBookings[] = $row->booking_id; @endphp
                                            </td>
                                            <td>
                                                <span class="badge badge-dark px-3 py-2" style="font-size: 0.9rem;">{{ $row->kode_seat }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        $("#table-download").DataTable({
            "responsive": true,
            "autoWidth": false,
            "pageLength": 25,
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                    className: 'btn-danger btn-sm rounded-pill px-3 mr-2',
                    title: 'Daftar Penumpang Bus {{ $id }}'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                    className: 'btn-success btn-sm rounded-pill px-3 mr-2',
                    title: 'Daftar Penumpang Bus {{ $id }}'
                },
                {
                    text: '<i class="fas fa-print mr-1"></i> Cetak KK',
                    className: 'btn-primary btn-sm rounded-pill px-3',
                    action: function(e, dt, button, config) {
                        window.location.href = `{{ route('bus.pdfKk', $busId) }}`;
                    }
                }
            ]
        });
    });
</script>
@endsection

@endsection
