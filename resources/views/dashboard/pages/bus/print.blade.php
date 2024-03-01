<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus {{ $bus->first()->id_bus }}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/admin/css/adminlte.css') }}">

    <style>
        @media print {
            .content {
                background-color: green;
            }
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="container-fluid">
            <img src="{{ asset('dist/img/header-surat.png') }}" class="img-fluid">
            <div class="mx-4">
                <div class="row">
                    <div class="col-7">
                        <h1>Bus {{ $bus->first()->id_bus.' - '.$bus->first()->trayek->jurusan }}</h1>
                        <h6>{{ $bus->first()->trayek->rute }}</h6>
                    </div>
                    <div class="col-3 mt-2 ml-4">
                        Total kursi : {{ $bus->first()->total_kursi }} kursi <br>
                        Total tersedia : {{ $bus->first()->total_kursi - $peserta->where('bus_id', $bus->first()->id_bus)->count() }} kursi <br>
                        Total dipesan  : {{ $peserta->where('bus_id', $bus->first()->id_bus)->count() }} kursi
                    </div>
                </div>

            </div>
            <div class="card col-md-4 mx-auto mt-5">

                <div class="card-body">
                    @foreach ($bus as $key => $row)
                    @php $bus = $row->id_bus; @endphp
                    <div class="row container text-center">

                        <div class="col-md-5 col-5 my-2">
                            <span class="border border-warning px-4 py-1">CO-DRIVER</span>
                        </div>
                        <div class="col-md-2 col-2 my-2"></div>
                        <div class="col-md-5 col-5 my-2">
                            <span class="border border-warning px-5 py-1">DRIVER</span>
                        </div>

                        <div class="col-md-5 col-5 my-2">
                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                <center>
                                    <div class="row">
                                        @foreach (json_decode($row->kd_seat_kiri, true) as $kode)
                                        @php $seatCode = $i . $kode . $bus; @endphp
                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                        <div class="col-md-6 col-6">
                                            <label class="bg-warning text-white rounded border border-warning p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-warning">{{ $i . $kode }}</b>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>
                                            </label>
                                        </div>
                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                        <div class="col-md-6 col-6">
                                            <label class="bg-danger text-white rounded border border-danger p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-danger">{{ $i . $kode }}</b>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>
                                            </label>
                                        </div>
                                        @else
                                        <div class="col-md-6 col-6">
                                            <label class="bg-success text-white rounded border border-success p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-success">{{ $i . $kode }}</b>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </center>
                                @endfor
                        </div>
                        <div class="col-md-2 col-2 my-2"></div>
                        <div class="col-md-5 col-5 my-2">
                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                <center>
                                    <div class="row">
                                        @foreach (json_decode($row->kd_seat_kanan, true) as $kode)
                                        @php $seatCode = $i . $kode . $bus; @endphp
                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                        <div class="col-md-6 col-6">
                                            <label class="bg-warning text-warning rounded border border-warning p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-warning">{{ $i . $kode }}</b> <br>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>

                                            </label>
                                        </div>
                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                        <div class="col-md-6 col-6">
                                            <label class="bg-danger text-danger rounded border border-danger p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-danger">{{ $i . $kode }}</b>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>
                                            </label>
                                        </div>
                                        @else
                                        <div class="col-md-6 col-6">
                                            <label class="bg-success text-success rounded border border-success p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                                <b class="text-success">{{ $i . $kode }}</b>
                                                <small class="text-dark">
                                                    <h6 class="mb-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->nama_peserta }}</h6>
                                                    <h6 class="mt-0">{{ $peserta->where('bus_id', $bus)->where('kode_seat', $i.$kode)->first()?->booking->uker->nama_unit_kerja }}</h6>
                                                </small>
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </center>
                                @endfor
                        </div>

                        @if ($row->total_kursi == 40)
                        <div class="col-md-5 col-5 my-2">
                            <label class="bg-secondary text-white rounded border border-dark p-3 w-100">
                                TOILET
                            </label>
                        </div>

                        <div class="col-md-1 col-1 my-2"></div>

                        <div class="col-md-6 col-6 my-2">
                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                <div class="row">
                                    @foreach (json_decode($row->kd_seat_belakang, true) as $key => $kode)
                                    @php $kdSeat = 10 + $i - 1; @endphp
                                    <div class="col-md-4 col-4 mt-3">
                                        <label class="bg-secondary text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                            {{ $kdSeat . $kode }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endfor
                        </div>
                        @endif

                        @if ($row->total_kursi == 37)
                        <div class="col-md-5 col-5 my-2 mt-5">
                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                <div class="row">
                                    @foreach (json_decode($row->kd_seat_belakang, true) as $key => $kode)
                                    @php $kdSeat = 10 + $i - 1; @endphp
                                    <div class="col-md-6 col-6">
                                        <label class="bg-secondary text-white rounded border border-dark p-2 w-100" for="seat{{ $i . $kode . $row }}">
                                            {{ $kdSeat . $kode }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endfor
                        </div>
                        <div class="col-md-2 col-2"></div>
                        <div class="col-md-5 col-5">
                            <label class="bg-secondary text-white rounded border border-dark w-100 mt-3" style="padding: 14%;">
                                TOILET
                            </label>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
