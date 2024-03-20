<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mudik Bersama Kemenkes</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/admin/css/adminlte.min.css') }}">
    <style>
        @media print {
            .pagebreak {
                page-break-after: always;
            }

            .table-data {
                border: 1px solid;
                font-size: 20px;
                vertical-align: middle;
            }

            .table-data th,
            .table-data td {
                border: 1px solid;
                vertical-align: middle;
            }

            .table-data thead th,
            .table-data thead td {
                border: 1px solid;
                vertical-align: middle;
            }
        }

        .divTable {
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            font-size: 21px;
        }

        .divThead {
            border-bottom: 1px solid;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container" style="font-size: 20px;">
        <p class="text-center">
            <img src="{{ asset('dist/img/logo-kemenkes.png') }}" class="img-fluid w-25">
        </p>
        <div class="float-left">
            <div class="text-uppercase h2 font-weight-bold text-info">
                <p>
                    Bus {{ $bus->id_bus }} - Daftar PESERTA <br class="mb-0">
                    <small class="text-lg font-weight-bold">{{ $bus->trayek->rute }}</small>
                </p>

            </div>
        </div>
        <div class="float-right mt-2">
            {{ \Carbon\carbon::now()->isoFormat('HH:mm') }} |
            {{ \Carbon\carbon::now()->isoFormat('DD MMMM Y') }}
        </div>
        <div class="table-responsive mt-5">
            <table class="table table-data text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 30%;">Nama Pegawai</th>
                        <th>Nama Peserta </th>
                        <th>Seat</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                @php
                $total = 0;
                $prevEmployeeId = null;
                $currentRow = 1;
                @endphp
                <tbody>
                    @foreach($peserta as $row)
                    <tr>
                        @if($row->booking->detail->count() > 1 && $row->booking->id_booking != $prevEmployeeId)
                        <td rowspan="{{ $row->booking->detail->count() }}">{{ $currentRow  }}</td>
                        <td class="text-left" rowspan="{{ $row->booking->detail->count() }}">
                            {{ $row->booking->kode_booking }} <br>
                            {{ $row->booking->nama_pegawai }} <br>
                            {{ $row->booking->uker?->nama_unit_kerja }}
                            @php $prevEmployeeId = $row->booking->id_booking; $total += 1; $currentRow += 1; @endphp
                        </td>
                        @elseif ($row->booking->detail->count() == 1)
                        <td>{{ $currentRow  }}</td>
                        <td class="text-left">
                            {{ $row->booking->kode_booking }} <br>
                            {{ $row->booking->nama_pegawai }} <br>
                            {{ $row->booking->uker?->nama_unit_kerja }}
                            @php $currentRow += 1; @endphp
                        </td>
                        @endif
                        <td class="text-left">{{ $row->nama_peserta }}</td>
                        <td>{{ $row->kode_seat }}</td>
                        <td>{{ strtoupper($row->booking->tujuan->nama_kota) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
