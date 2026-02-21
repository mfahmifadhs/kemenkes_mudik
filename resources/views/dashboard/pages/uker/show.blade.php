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
                <div class="col-sm-12">
                    <h1 class="m-0">
                        <small>Daftar Unit Kerja</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Daftar Unit Kerja</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card w-100">
                <div class="card-header">
                    <label>Tabel Daftar Unit Kerja</label>
                </div>
                <div class="card-header">
                    <div class="">
                        <table id="table" class="table table-bordered text-center">
                            <thead class="text-sm">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Utama</th>
                                    <th>Unit Kerja</th>
                                    <th>Nama PIC</th>
                                    <th>No HP PIC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($uker as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $row->unitUtama->nama_unit_utama }}</td>
                                    <td class="text-left">{{ $row->nama_unit_kerja }}</td>
                                    <td class="text-left">{{ $row->pic_nama }}</td>
                                    <td class="text-left">{{ $row->pic_nohp }}</td>
                                    <td>
                                        <a href="{{ route('uker.edit', $row->id_unit_kerja) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
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
    </div><br>
</div>

@endsection
