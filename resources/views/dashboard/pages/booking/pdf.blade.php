<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>

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
                <p>Daftar PESERTA</p>
            </div>
        </div>
        <div class="float-right">
            {{ \Carbon\carbon::now()->isoFormat('HH:mm') }} |
            {{ \Carbon\carbon::now()->isoFormat('DD MMMM Y') }}
        </div>
        <div class="table-responsive mt-5">
            <table class="table table-data text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>Tiket</th>
                        <th style="width: 20%;">Nama</th>
                        <th>Bis</th>
                        <th>Seat</th>
                        <th>Trayek</th>
                    </tr>
                </thead>
                @php $no = 1; @endphp
                @foreach($book as $row)
                @foreach($row->detail as $subRow)
                <thead style="font-size: 16px;">
                    <tr>
                        <td>
                            {{ $no++ }}
                            @if ($row->status == 'true') <i class="fas fa-check-circle text-success"></i>@endif
                            @if ($row->status == 'false') <i class="fas fa-times-circle text-danger"></i>@endif
                            @if ($row->status == null) <i class="fas fa-clock text-warning"></i>@endif
                        </td>
                        <td class="text-left">{{ $row->uker->nama_unit_kerja }}</td>
                        <td class="text-left">
                            {{ Carbon\Carbon::parse($subRow->created_at)->isoFormat('DD MMMM Y') }} <br>
                            {{ $row->id_booking }}
                        </td>
                        <td class="text-left">
                            {{ $subRow->nama_peserta }} <br>
                            {{ $subRow->usia }} tahun <br>
                            {{ $subRow->nik }}
                        </td>
                        <td>{{ $subRow->bus_id }}</td>
                        <td>{{ $subRow->kode_seat }}</td>
                        <td class="text-left">
                            {{ $subRow->booking->rute->jurusan }} <br>
                            {{ $subRow->booking->rute->rute }}
                        </td>
                    </tr>
                </thead>
                @endforeach
                @endforeach
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
