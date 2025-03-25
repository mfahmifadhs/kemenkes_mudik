@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0"> Bus {{ $bus->first()->id_bus }}, <small>{{ $bus->first()->trayek->jurusan }}</small></h1>
                    <h6 class="text-sm">{{ $bus->first()->trayek->rute }}</h6>
                </div>
                <div class="col-sm-4 text-right mt-2">
                    <a href="{{ url()->previous() }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    @foreach ($bus as $key => $row)
                    @php $bus = $row->id_bus; @endphp
                    <div class="row container text-center">

                        <div class="col-md-5 my-2">
                            <span class="border border-warning px-4 py-1">CO-DRIVER</span>
                        </div>
                        <div class="col-md-2 my-2"></div>
                        <div class="col-md-5 my-2">
                            <span class="border border-warning px-5 py-1">DRIVER</span>
                        </div>

                        <div class="col-md-5 my-2">
                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                <center>
                                    <div class="row">
                                        @foreach (json_decode($row->kd_seat_kiri, true) as $kode)
                                        @php $seatCode = $i . $kode . $bus; @endphp
                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                        <div class="col-md-6">
                                            <label class="bg-warning text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                        <div class="col-md-6">
                                            <label class="bg-danger text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <label class="bg-success text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </center>
                                @endfor
                        </div>
                        <div class="col-md-2 my-2"></div>
                        <div class="col-md-5 my-2">
                            @for ($i = 1; $i <= $row->seat_kanan; $i++)
                                <center>
                                    <div class="row">
                                        @foreach (json_decode($row->kd_seat_kanan, true) as $kode)
                                        @php $seatCode = $i . $kode . $bus; @endphp
                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                        <div class="col-md-6">
                                            <label class="bg-warning text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                        <div class="col-md-6">
                                            <label class="bg-danger text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <label class="bg-success text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                {{ $i . $kode }}
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </center>
                                @endfor
                        </div>

                        @if ($row->total_kursi == 40)
                        <div class="col-md-5 my-2">
                            <label class="bg-secondary text-white rounded border border-dark p-3 w-100">
                                TOILET
                            </label>
                        </div>

                        <div class="col-md-1 my-2"></div>

                        <div class="col-md-6 my-2">
                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                <div class="row">
                                    @foreach (json_decode($row->kd_seat_belakang, true) as $key => $kode)
                                    @php $kdSeat = 10 + $i - 1; @endphp
                                    <div class="col-md-4 mt-3">
                                        <label class="bg-secondary text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                            {{ $kdSeat . $kode }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endfor
                        </div>
                        @endif

                        @if ($row->total_kursi == 36 || $row->total_kursi == 50)
                        <div class="col-md-12 my-2">
                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                <center>
                                    <div class="row">
                                        @foreach (json_decode($row->kd_seat_belakang, true) as $kode)
                                        @php $seatCode = '12' . $kode . $bus; @endphp
                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                        <div class="col-md-2">
                                            <label class="bg-warning text-white rounded border border-dark p-2 w-100" for="seat{{ '12' . $kode . $row }}">
                                                {{ '12' . $kode }}
                                            </label>
                                        </div>
                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                        <div class="col-md-2">
                                            <label class="bg-danger text-white rounded border border-dark p-2 w-100" for="seat{{ '12' . $kode . $row }}">
                                                {{ '12' . $kode }}
                                            </label>
                                        </div>
                                        @else
                                        <div class="col-md-2">
                                            <label class="bg-success text-white rounded border border-dark p-2 w-100" for="seat{{ '12' . $kode . $row }}">
                                                {{ '12' . $kode }}
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </center>
                                @endfor
                        </div>
                        <!-- <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <label class="bg-secondary text-white rounded border border-dark w-100 mt-3" style="padding: 14%;">
                                TOILET
                            </label>
                        </div> -->
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="col-md-8">
                    <!-- @if (Auth::user()->role_id == 2)
                    <a href="{{ route('bus.pdfSeat', $bus) }}" class="btn btn-danger btn-sm my-2" target="__blank">
                        <i class="fas fa-print"></i> Cetak Kursi
                    </a>
                    <a href="{{ route('bus.pdfKk', $bus) }}" class="btn btn-danger btn-sm my-2" target="__blank">
                        <i class="fas fa-print"></i> Cetak Pegawai
                    </a>
                    @endif -->
                    <div class="card">
                        <div class="card-body">
                            <table id="table-download" class="table text-center text-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;">No</th>
                                        <th style="width: auto;">Unit Kerja</th>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 10%;">Tujuan</th>
                                        <th style="width: 20%;">Nama</th>
                                        <th style="width: 10%;">Telpon</th>
                                        <th style="width: 10%;">Usia</th>
                                        <th style="width: 10%;">NIK</th>
                                        <th style="width: 12%size ;">Kursi</th>
                                    </tr>
                                </thead>
                                @php
                                $shownBookings = [];
                                @endphp
                                <tbody>
                                    @foreach ($peserta as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                            @if ($row->status == 'cancel') <i class="fas fa-times-circle text-danger"></i> @endif
                                            @if ($row->status == 'book') <i class="fas fa-clock text-warning"></i> @endif
                                            @if ($row->status == 'full') <i class="fas fa-check-circle text-success"></i> @endif
                                        </td>
                                        <td class="text-left">
                                            {{ $row->booking->uker->nama_unit_kerja }}
                                        </td>
                                        <td>{{ $row->booking->kode_booking  }}</td>
                                        <td class="text-left">
                                            {{ $row->booking->tujuan->nama_kota }}
                                        </td>
                                        <td class="text-left">{{ $row->nama_peserta }}</td>
                                        @if (!in_array($row->booking_id, $shownBookings))
                                        <td>{{ $row->booking->no_telp }}</td>
                                        @php
                                        $shownBookings[] = $row->booking_id;
                                        @endphp
                                        @else
                                        <td>-</td> {{-- Kosongkan jika sudah ditampilkan --}}
                                        @endif
                                        <td>{{ $row->usia }} tahun</td>
                                        <td>{{ $row->nik }}</td>
                                        <td>{{ $row->kode_seat }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
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

<script>
    $("#uker").select2()
    $("#table-download").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger',
            title: 'Bus - ' + `{{ $id }}`,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 7],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success',
            title: 'Bus - ' + `{{ $id }}`,
            exportOptions: {
                columns: ':not(:nth-child(2))'
            },
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-download_wrapper .col-md-6:eq(0)');
</script>
@endsection

@endsection
