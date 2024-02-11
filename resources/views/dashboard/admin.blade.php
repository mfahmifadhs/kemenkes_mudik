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
                                <label>Rekap Trayek</label>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="text-sm">
                                        <tr>
                                            <th style="width: 0%;">No</th>
                                            <th style="width: 10%;">Jurusan</th>
                                            <th style="width: 45%;">Rute</th>
                                            <th style="width: 12%;">Total Kursi</th>
                                            <th style="width: 12%;">Total Tersedia</th>
                                            <th style="width: 12%;">Total Dipesan</th>
                                            <th style="width: 12%;">Total Terisi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @foreach($trayek as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->jurusan }}</td>
                                            <td class="text-left">{{ $row->rute }}</td>
                                            <td>{{ $row->bus->sum('total_kursi') }}</td>
                                            <td>{{ $row->bus->sum('total_kursi') - $row->book->flatMap->detail->where('status', '!=', 'cancel')->count() }}</td>
                                            <td>{{ $row->book->flatMap->detail->where('status', 'book')->count() }}</td>
                                            <td>{{ $row->book->flatMap->detail->where('status', 'full')->count() }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="card w-100">
                                <div class="card-header mt-2">
                                    <div class="float-left">
                                        <label>Rekap Unit Kerja</label>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <div class="">
                                        <table id="table" class="table table-bordered text-center">
                                            <thead class="text-sm">
                                                <tr>
                                                    <th style="width: 0%;">No</th>
                                                    <th>Nama Unit Kerja</th>
                                                    <th style="width: 20%;">Total Dipesan</th>
                                                    <th style="width: 20%;">Total Terisi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-sm">
                                                @foreach($uker as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $row->nama_unit_kerja }}</td>
                                                    <td>{{ $row->book->flatMap->detail->where('status', 'book')->count() }}</td>
                                                    <td>{{ $row->book->flatMap->detail->where('status', 'full')->count() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $book->flatMap->detail->where('status', 'full')->count() }} <small class="text-xs">pemesanan</small></h3>
                                    <p>Sudah Disetujui</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $book->flatMap->detail->where('status', 'book')->count() }} <small class="text-xs">pemesanan</small></h3>
                                    <p>Proses Validasi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $book->flatMap->detail->where('status', 'cancel')->count() }} <small class="text-xs">pemesanan</small></h3>
                                    <p>Tidak Disetujui</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
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
                                                @php $seat = $subRow->total_kursi - $subRow->detail->where('status', 'full')->count(); @endphp
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
