@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0"> Detail Boking <small>({{ $book->kode_booking }})</small></h5>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('dashboard') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <center>
                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                    <div class="timeline-step">
                        <div class="timeline-content">
                            @if (!$book->approval_uker)
                            <i class="fas fa-dot-circle fa-2x text-danger"></i>
                            @else
                            <i class="fas fa-dot-circle fa-2x text-success"></i>
                            @endif
                            <p class="text-muted mb-0 mb-lg-0 mt-2">
                                Verifikasi Unit Kerja
                            </p>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-content">
                            @if (!$book->approval_roum)
                            <i class="fas fa-dot-circle fa-2x text-danger"></i>
                            @else
                            <i class="fas fa-dot-circle fa-2x text-success"></i>
                            @endif

                            <p class="text-muted mb-0 mb-lg-0 mt-2">
                                Verifikasi Biro Umum
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-left text-sm">
                        <label>Rincian Pegawai</label>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row ml-3 my-2">
                                    <div class="col-md-2">Kode Boking</div>
                                    <div class="col-md-9">: {{ $book->kode_booking }}</div>
                                    <div class="col-md-2">Nama Pegawai</div>
                                    <div class="col-md-9">: {{ $book->nama_pegawai }}</div>
                                    <div class="col-md-2">NIK/NIP</div>
                                    <div class="col-md-9">: {{ $book->nip_nik }}</div>
                                    <div class="col-md-2">No. Telp</div>
                                    <div class="col-md-9">: {{ $book->no_telp }}</div>
                                    <div class="col-md-2">Alamat</div>
                                    <div class="col-md-9">: {{ $book->alamat }}</div>
                                    <div class="col-md-2">Unit Kerja</div>
                                    <div class="col-md-9">: {{ $book->uker->nama_unit_kerja }}</div>
                                    <div class="col-md-2">Foto KTP</div>
                                    <div class="col-md-9">:
                                        @if ($book->foto_ktp)
                                        <a class="text-primary" href="#" data-toggle="modal" data-target="#ktp">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </div>
                                    <div class="col-md-2">Foto Kartu Keluarga</div>
                                    <div class="col-md-9">:
                                        @if ($book->foto_kk)
                                        <a class="text-primary" href="#" data-toggle="modal" data-target="#kk">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                @if (!$book->approval_uker && !$book->approval_roum)
                                <i class="fas fa-history text-warning fa-6x" style="opacity: 0.4;"></i>
                                @endif

                                @if ($book->approval_uker == 'true' && $book->approval_roum == 'true')
                                <i class="fas fa-check-circle text-success fa-6x" style="opacity: 0.4;"></i>
                                @endif

                                @if ($book->approval_uker == 'false' || $book->approval_roum == 'false')
                                <i class="fas fa-times-circle text-danger fa-6x mb-2" style="opacity: 0.4;"></i><br>
                                <span class="text-danger">{{ $book->catatan }}</span>
                                @endif
                            </div>
                        </div>

                        <label class="my-2">Rincian Peserta</label>
                        <table class="table table-bordered text-center ">
                            <thead>
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">Nama Peserta</th>
                                    <th class="align-middle">Usia</th>
                                    <th class="align-middle">NIK</th>
                                    <th class="align-middle">Kode Seat</th>
                                    <th class="align-middle">Bus</th>
                                    <th style="width: 10%;">Sertifikat Vaksin 1</th>
                                    <th style="width: 10%;">Sertifikat Vaksin 2</th>
                                    <th style="width: 10%;">Sertifikat Vaksin 3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($book->detail as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama_peserta }}</td>
                                    <td>{{ (int) $row->usia.' Tahun' }}</td>
                                    <td>{{ $row->nik }}</td>
                                    <td>{{ $row->kode_seat }}</td>
                                    <td>{{ $row->bus_id }}</td>
                                    <td>
                                        @if ($row->foto_vaksin_1)
                                        <a class="text-primary" href="#" onclick="openModal(1, '{{ $row->id_peserta }}')">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </td>
                                    <td>
                                        @if ($row->foto_vaksin_2)
                                        <a class="text-primary" href="#" onclick="openModal(2, '{{ $row->id_peserta }}')">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </td>
                                    <td>
                                        @if ($row->foto_vaksin_3)
                                        <a class="text-primary" href="#" onclick="openModal(3, '{{ $row->id_peserta }}')">
                                            <u>Lihat foto</u>
                                        </a>
                                        @else Tidak ada @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (!$book->status && $book->uker_id == Auth::user()->uker_id && Auth::user()->role_id == 4 && !$book->approval_uker)
                    <div class="card-footer text-right font-weight-bold">
                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#tolak">
                            <i class="fas fa-times-circle"></i> Tolak
                        </a>
                        <a href="{{ route('book.true', $book->id_booking) }}" class="btn btn-success" onclick="confirmTrue(event)">
                            <i class="fas fa-check-circle"></i> Setuju
                        </a>
                    </div>
                    @endif

                    @if ($book->status == 'true')
                    <div class="card-footer text-right font-weight-bold">
                        <a id="download" class="btn btn-success btn-sm" data-url="{{ route('tiket.cetak', $book->id_booking) }}" target="_blank">
                            <i class="fas fa-paper-plane"></i> <b>Kirm Email</b>
                        </a>
                    </div>
                    @endif
                    @if (Auth::user()->role_id == 2 && !$book->approval_roum && $book->approval_uker == 'true')
                    <div class="card-footer text-right font-weight-bold">
                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#tolak">
                            <i class="fas fa-times-circle"></i> Tolak
                        </a>
                        <a href="{{ route('book.true', $book->id_booking) }}" class="btn btn-success" onclick="confirmTrue(event)">
                            <i class="fas fa-check-circle"></i> Setuju
                        </a>
                    </div>
                    @endif

                    @if ($book->approval_roum == 'true')
                    <div class="card-footer text-right font-weight-bold">
                        <a id="download" class="btn btn-success btn-sm" data-url="{{ route('tiket.email', $book->id_booking) }}" target="_blank">
                            <i class="fas fa-paper-plane"></i> <b>Kirm Email</b>
                        </a>
                    </div>
                    @endif
                </div>
            </center>
        </div>
    </div><br>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="tolak" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Alasan Penolakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('book.false', $book->id_booking) }}" method="POST">
                @csrf
                <input type="hidden" name="tolak" value="true">
                <div class="modal-body">
                    <p>Alasan Penolakkan Peserta</p>
                    <textarea name="catatan" class="form-control" cols="10" rows="5" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default border-dark" onclick="confirmFalse(event, this)">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal KTP -->
<div class="modal fade" id="ktp" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/foto_ktp/'. $book->foto_ktp) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Modal KK -->
<div class="modal fade" id="kk" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Kartu Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/foto_kk/'. $book->foto_kk) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Modal Sertifikas Vaksin -->
@foreach ($book->detail as $i => $row)
@php $key = $i + 1; @endphp
<div class="modal fade" id="vaksin1{{ $row->id_peserta }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Sertifikat Vaksin 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/vaksin_1/' . $row->foto_vaksin_1) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="vaksin2{{ $row->id_peserta }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Sertifikat Vaksin 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/vaksin_2/' . $row->foto_vaksin_2) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="vaksin3{{ $row->id_peserta }}" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="mt-2 font-weight-bold">Sertifikat Vaksin 3</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/files/vaksin_3/' . $row->foto_vaksin_3) }}" class="img-fluid mt-3" alt="">
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    function openModal(key, idPeserta) {
        const modalId = `#vaksin${key}${idPeserta}`;
        console.log(modalId)
        $(modalId).modal('show');
    }

    function confirmTrue(event) {
        event.preventDefault();

        const url = event.currentTarget.href;

        Swal.fire({
            title: 'Setuju',
            text: 'Apakah peserta ini disetujui ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmFalse(event, button) {
        event.preventDefault();
        var form = $(button).closest('form');

        Swal.fire({
            title: 'Tolak',
            text: 'Apakah peserta ini ditolak?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

<script>
    document.getElementById('download').addEventListener('click', function(event) {
        event.preventDefault();
        const url = event.currentTarget.dataset.url;

        Swal.fire({
            title: 'Sedang Mengirim...',
            allowOutsideClick: true,
            showConfirmButton: false,
            timer: 9000,
            onBeforeOpen: () => {
                Swal.showLoading();
                window.location.href = url;
            },
        });
    });
</script>
@endsection
@endsection
