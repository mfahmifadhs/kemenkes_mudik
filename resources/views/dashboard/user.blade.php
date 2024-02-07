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
                                            <th style="width: 10%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @foreach($book as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM Y | HH:mm:ss') }}</td>
                                            <td class="text-left">
                                                <div class="row">
                                                    <div class="col-md-4">Kode Boking</div>
                                                    <div class="col-md-7">: {{ $row->id_booking }}</div>
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
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                {{ $row->rute->jurusan }} <br>
                                                {{ $row->rute->rute }}
                                            </td>
                                            <td>{{ strtoupper($row->tujuan->nama_kota) }}</td>
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
                            @foreach ($rute as $row)
                            <p>
                                <span class="text-sm">{{ $loop->iteration.'. '.$row->jurusan }} </span><br>
                                <span class="text-xs">{{ $row->rute }}</span>
                            </p>
                            <p>
                                @foreach ($row->bus as $subRow)
                                <a href="" class="btn btn-default">
                                    <i class="fas fa-bus fa-2x"></i>
                                </a>
                                @endforeach
                            </p>
                            <hr>
                            @endforeach
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
