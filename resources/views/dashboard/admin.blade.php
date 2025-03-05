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
                    @if (Auth::user()->role_id == 2)
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
                                            <th style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @foreach($book->where('approval_uker', 'true')->where('approval_roum', null) as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM Y | HH:mm:ss') }}</td>
                                            <td class="text-left">
                                                <div class="row">
                                                    <div class="col-md-4">Kode Boking</div>
                                                    <div class="col-md-7">: {{ $row->kode_booking }}</div>
                                                    <div class="col-md-4">Nama</div>
                                                    <div class="col-md-7">: {{ $row->nama_pegawai }}</div>
                                                    <div class="col-md-4">NIP/NIK</div>
                                                    <div class="col-md-7">: {{ $row->nip_nik }}</div>
                                                    <div class="col-md-4">No. Telp</div>
                                                    <div class="col-md-7">: {{ $row->no_telp }}</div>
                                                    <div class="col-md-4">Jumlah</div>
                                                    <div class="col-md-7">: {{ $row->detail->count() }} orang</div>
                                                    <div class="col-md-4">Unit Kerja</div>
                                                    <div class="col-md-7">: {{ $row->uker->nama_unit_kerja }}</div>
                                                    @if ($row->nama_upt)
                                                    <div class="col-md-4">Nama UPT</div>
                                                    <div class="col-md-7">: {{ $row->nama_upt }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                {{ $row->rute->jurusan }} <br>
                                                {{ $row->rute->rute }}
                                            </td>
                                            <td>{{ strtoupper($row->tujuan->nama_kota) }}</td>
                                            <td>
                                                @if ($row->approval_uker == true)
                                                <label class="mb-1 btn-xs border-dark text-xs text-success">
                                                    <span class="text-xs">
                                                        <i class="fas fa-check-circle"></i> Unit Kerja
                                                    </span>
                                                </label>
                                                @elseif ($row->approval_uker == false)
                                                <label class="mb-1 btn-xs border-dark text-xs text-success">
                                                    <span class="text-xs">
                                                        <i class="fas fa-check-circle"></i> Unit Kerja
                                                    </span>
                                                </label>
                                                @endif


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
                    @endif

                    <label>Total Pemesanan</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $book->where('approval_roum', 'true')->count() }} <small class="text-xs">pemesanan</small></h3>
                                    <p><b>Sudah Disetujui</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>
                                        {{ $book->where('approval_uker', null)->count() + $book->where('approval_uker', 'true')->where('approval_roum', null)->count() }}
                                        <small class="text-xs">pemesanan</small>
                                    </h3>
                                    <p><b>Proses Verifikasi</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>
                                        {{ $book->where('approval_uker', 'false')->count() + $book->where('approval_roum', 'false')->count() }}
                                        <small class="text-xs">pemesanan</small>
                                    </h3>
                                    <p><b>Tidak Disetujui</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label>Total Kursi</label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $bus->sum('total_kursi') }} <small class="text-xs">kursi</small></h3>
                                    <p><b>Total Kursi</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-bus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    @php
                                    $seatUker = $book->where('approval_uker', null)->flatMap->detail->count();
                                    $seatRoum = $book->where('approval_uker', 'true')->where('approval_roum', null)->flatMap->detail->count();
                                    @endphp
                                    <h3>{{ $seatUker + $seatRoum }} <small class="text-xs">kursi</small></h3>
                                    <p><b>Proses Verifikasi</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    @php
                                    $seatFull = $book->flatMap->detail->where('status', 'full')->where('kode_seat', '!=', null)->count();
                                    @endphp
                                    <h3>{{ $seatFull }} <small class="text-xs">kursi</small></h3>
                                    <p><b>Tidak Tersedia</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $bus->sum('total_kursi') - ($seatUker + $seatRoum + $seatFull) }} <small class="text-xs">kursi</small></h3>
                                    <p><b>Tersedia</b></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        @php
                                        // Inisialisasi variabel total
                                        $totalKursi = 0;
                                        $totalTersedia = 0;
                                        $totalDipesan = 0;
                                        $totalTerisi = 0;
                                        @endphp

                                        @foreach($trayek as $row)
                                        @php
                                        // Hitung nilai untuk setiap baris
                                        $kursi = $row->bus->sum('total_kursi');
                                        $tersedia = $kursi - $row->book->flatMap->detail->where('status', '!=', 'cancel')->count();
                                        $dipesan = $row->book->flatMap->detail->where('status', 'book')->count();
                                        $terisi = $row->book->flatMap->detail->where('status', 'full')->count();

                                        // Tambahkan ke total
                                        $totalKursi += $kursi;
                                        $totalTersedia += $tersedia;
                                        $totalDipesan += $dipesan;
                                        $totalTerisi += $terisi;
                                        @endphp

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->jurusan }}</td>
                                            <td class="text-left">{{ $row->rute }}</td>
                                            <td>{{ $kursi }}</td>
                                            <td>{{ $tersedia }}</td>
                                            <td>{{ $dipesan }}</td>
                                            <td>{{ $terisi }}</td>
                                        </tr>
                                        @endforeach

                                        <!-- Baris Total -->
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                                            <td><strong>{{ $totalKursi }}</strong></td>
                                            <td><strong>{{ $totalTersedia }}</strong></td>
                                            <td><strong>{{ $totalDipesan }}</strong></td>
                                            <td><strong>{{ $totalTerisi }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card w-100">
                        <div class="card-header mt-2">
                            <div class="float-left">
                                <label>Rekap Tujuan</label>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="table-responsive">
                                <table id="table-data" class="table table-bordered text-center">
                                    <thead class="text-sm">
                                        <tr>
                                            <th style="width: 0%;">No</th>
                                            <th style="width: 10%;">Jurusan</th>
                                            <th>Rute</th>
                                            <th>Tujuan</th>
                                            <th style="width: 10%;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @foreach($tujuan as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->tujuan->trayek->jurusan }}</td>
                                            <td class="text-left">{{ $row->tujuan->trayek->rute }}</td>
                                            <td>{{ $row->tujuan->nama_kota }}</td>
                                            <td>{{ $row->total }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

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
