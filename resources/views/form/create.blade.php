@extends('form.layout.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 lg:p-8">
    <div class="flex justify-center mt-0">
        <div class="card w-100">
            <div class="card-header">
                <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="200">
            </div>
            @if (!$step )
            <div id="identitas" class="card-body">
                <p class="text-center text-lg"><b>Form Registrasi Mudik Bersama Kemenkes</b></p>
                <hr class="my-2">
                <form id="form" action="{{ route('form.create') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">Unit Utama</div>
                        <div class="col-md-9">
                            <select id="utamaSelect" name="utama" class="form-control border-dark">
                                <option value="">-- Pilih Unit Utama --</option>
                                @foreach($utama as $row)
                                <option value="{{ $row->id_unit_utama }}">{{ $row->nama_unit_utama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">Unit Kerja</div>
                        <div class="col-md-9">
                            <select id="ukerSelect" name="uker" class="form-control border-dark">
                                <option value="">-- Pilih Unit Kerja --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">Nama Lengkap</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control border-dark" name="nama">
                        </div>
                    </div>

                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">NIP/NIK</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control border-dark" name="nip_nik">
                        </div>
                    </div>

                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">No. Telepon</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control border-dark" name="no_telp">
                        </div>
                    </div>

                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">Alamat</div>
                        <div class="col-md-9">
                            <textarea type="text" class="form-control border-dark" name="alamat"></textarea>
                        </div>
                    </div>


                    <div class="form-group row my-2">
                        <div class="col-md-3 col-form-label">Rute Tujuan</div>
                        <div class="col-md-9">
                            <select id="ruteSelect" name="rute" class="form-control border-dark" required>
                                <option value="">-- Pilih Rute --</option>
                                @foreach ($trayek as $row)
                                <option value="{{ $row->id_trayek }}">
                                    {{ $row->jurusan }} - {{ $row->rute }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row my-3">
                        <div class="col-md-3 col-form-label">Kota Tujuan</div>
                        <div class="col-md-9">
                            <select id="destSelect" name="dest" class="form-control border-dark">
                                <option value="">-- Pilih Kota Tujuan --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <div class="col-md-12">
                            <label class="text-sm text-danger">
                                Mohon persiapkan dokumen pendukung antara lain :
                                <li class="mx-4">Foto KTP</li>
                                <li class="mx-4">Foto Kartu Keluarga</li>
                                <li class="mx-4">Sertifikat Vaksin 1,2,3 setiap penumpang</li>
                            </label>
                        </div>
                    </div>
                    <div class="form-group pt-2">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-default border-dark text-dark">
                                    Selanjutnya <i class="fa-solid fa-square-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @elseif ($rute && $step == 1)
            <div id="bus" class="card-body">
                <form action="{{ route('form.create') }}" method="GET">
                    @csrf
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="rute" value="{{ $rute->id_trayek }}">
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <ul class="nav" id="tab" role="tablist">
                                @foreach ($bus as $key => $row)
                                <li class="nav-item mr-2">
                                    <a class="btn btn-default border-secondary {{ $key == 0 ? 'active bg-info' : '' }} mx-2" data-toggle="pill" href="#bus-{{ $row->id_bus }}" role="tab" aria-selected="true">
                                        <b>BUS {{ $row->id_bus }}</b><br>
                                        <small class="text-success">Tersedia <b>{{ $row->total_kursi - $row->detail->where('status', '!=', 'cancel')->count() }}</b> seat</small>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="tabContent">
                                <!-- Usulan Pengadaan -->
                                @foreach ($bus as $key => $row)
                                @php
                                $active = $key == 0 ? 'show active' : '';
                                $bus = $row->id_bus;
                                @endphp
                                <div class="tab-pane fade {{ $active }}" id="bus-{{ $row->id_bus }}" role="tabpanel">
                                    <div class="row container text-center">

                                        <div class="col-md-5 col-5 my-2">
                                            <span class="border border-warning px-4 py-1">CO-DRIVER</span>
                                        </div>
                                        <div class="col-md-2 col-1 my-2"></div>
                                        <div class="col-md-5 col-6 my-2">
                                            <span class="border border-warning px-5 py-1">DRIVER</span>
                                        </div>

                                        <div class="col-md-5 col-5 my-2">
                                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                                <div class="row">
                                                    <center>
                                                        @foreach (json_decode($row->kd_seat_kiri, true) as $kode)
                                                        @php $seatCode = $i . $kode . $bus; @endphp
                                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                                        <label class="col-md-4 col-4 bg-warning rounded border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                                        <label class="col-md-4 col-4 bg-secondary text-white rounded border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @else
                                                        <label class="col-md-4 col-4 btn btn-success border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            <input name="seat[]" type="checkbox" class="seat-checkbox" id="seat{{ $i . $kode . $bus }}" value="{{ $bus.'-'.$i . $kode }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @endif
                                                        @endforeach
                                                    </center>
                                                </div>
                                                @endfor
                                        </div>
                                        <div class="col-md-2 col-1 my-2"></div>
                                        <div class="col-md-5 col-6 my-2">
                                            @for ($i = 1; $i <= $row->seat_kiri; $i++)
                                                <div class="row">
                                                    <center>
                                                        @foreach (json_decode($row->kd_seat_kanan, true) as $kode)
                                                        @php $seatCode = $i . $kode . $bus; @endphp
                                                        @if ($seatCek->where('seat_booked', $seatCode)->where('status', 'book')->isNotEmpty())
                                                        <label class="col-md-4 col-4 bg-warning rounded border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @elseif ($seatCek->where('seat_booked', $seatCode)->where('status', 'full')->isNotEmpty())
                                                        <label class="col-md-4 col-4 bg-secondary text-white rounded border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @else
                                                        <label class="col-md-4 col-4 btn btn-success border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            <input name="seat[]" type="checkbox" class="seat-checkbox" id="seat{{ $i . $kode . $bus }}" value="{{ $bus.'-'.$i . $kode }}">
                                                            {{ $i . $kode }}
                                                        </label>
                                                        @endif
                                                        @endforeach
                                                    </center>
                                                </div>
                                                @endfor
                                        </div>

                                        @if ($row->total_kursi == 40)
                                        <div class="col-md-5 col-4 my-2">
                                            <label class="bg-secondary text-white rounded border border-dark m-2 p-2 w-75">
                                                TOILET
                                            </label>
                                        </div>

                                        <div class="col-md-2 col-1 my-2"></div>

                                        <div class="col-md-5 col-7 my-2">
                                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                                <div class="row">
                                                    <center>
                                                        @foreach (json_decode($row->kd_seat_belakang, true) as $key => $kode)
                                                        @php $kdSeat = 10 + $i - 1; @endphp
                                                        <label class="col-md-3 col-3 bg-secondary text-white rounded border border-dark m-1 mt-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $kdSeat . $kode }}
                                                        </label>
                                                        @endforeach
                                                    </center>
                                                </div>
                                                @endfor
                                        </div>
                                        @endif

                                        @if ($row->total_kursi == 37)
                                        <div class="col-md-5 col-5 my-2 mt-5">
                                            @for ($i = 1; $i <= $row->seat_belakang; $i++)
                                                <div class="row">
                                                    <center>
                                                        @foreach (json_decode($row->kd_seat_belakang, true) as $key => $kode)
                                                        @php $kdSeat = 10 + $i - 1; @endphp
                                                        <label class="col-md-4 bg-secondary text-white rounded border border-dark m-2 p-2" for="seat{{ $i . $kode . $bus }}">
                                                            {{ $kdSeat . $kode }}
                                                        </label>
                                                        @endforeach
                                                    </center>
                                                </div>
                                                @endfor
                                        </div>
                                        <div class="col-md-2 col-1 my-2"></div>
                                        <div class="col-md-5 col-6 my-2">
                                            <label class="bg-secondary text-white rounded border border-dark m-2 w-75" style="padding: 4vh;">
                                                TOILET
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group pt-5">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-left">
                                        <a onclick="goBack()" class="btn btn-default border-dark text-dark">
                                            <i class="fa-solid fa-square-caret-left"></i> Sebelumnya
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-6 text-right">
                                        <button type="submit" class="btn btn-default border-dark text-dark">
                                            Selanjutnya <i class="fa-solid fa-square-caret-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @elseif ($step == 2)
            <div id="peserta" class="card-body">
                <form id="form" action="{{ route('form.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="rute" value="{{ $rute->id_trayek }}">
                    <input type="hidden" name="data" value="{{ json_encode($data) }}">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-body">
                            <div class="mb-4">
                                <h5><b>Informasi Peserta</b></h5>
                                <small>
                                    Mohon untuk mengisi dan melengkapi Nama Lengkap dan NIK peserta.
                                    <p>Peserta <b>Wajib</b> Mengupload Sertifikat Vaksin 1 sampai Vaksin 3</p>
                                </small>
                            </div>

                            <div class="form-group row my-3">
                                <div class="col-md-3 mt-1">
                                    Foto KTP
                                    <h6 style="font-size: 10px;">Maks. 5 mb</h6>
                                </div>
                                <div class="col-md-9">
                                    <div class="btn btn-default btn-sm btn-block btn-file border-dark w-100 p-2">
                                        <input id="fileImage" type="file" name="foto_ktp" class="image-atk w-100" required accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row my-3">
                                <div class="col-md-3 mt-1">
                                    Kartu Keluarga
                                    <h6 style="font-size: 10px;">Maks. 5 mb</h6>
                                </div>
                                <div class="col-md-9">
                                    <div class="btn btn-default btn-sm btn-block border-dark w-100 p-2">
                                        <input id="fileImage" type="file" name="foto_kk" class="image-atk w-100" required accept=".jpg, .jpeg, .png">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            @foreach ($seat as $key =>$row)
                            <div class="form-group row">
                                <div class="col-md-12"><b>Peserta {{ $loop->iteration }}</b></div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-md-3 my-1">Nomor Bus</div>
                                <div class="col-md-3 my-1">
                                    <input type="text" class="form-control form-control-sm text-center" name="bus[]" value="{{ explode('-', $row, 2)[0] }}" readonly>
                                </div>
                                <div class="col-md-3 my-1">Nomor Kursi</div>
                                <div class="col-md-3 my-1">
                                    <input type="text" class="form-control form-control-sm text-center" name="seat[]" value="{{ explode('-', $row, 2)[1] }}" readonly>
                                </div>
                                <div class="col-md-3 col-form-label">Nama Peserta</div>
                                <div class="col-md-5 my-1">
                                    <input type="text" name="peserta[]" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-1 col-form-label">Usia</div>
                                <div class="col-md-3 my-1">
                                    <input type="number" name="usia_peserta[]" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3 col-form-label">NIK</div>
                                <div class="col-md-5 my-1">
                                    <input type="text" name="nik_peserta[]" class="form-control form-control-sm number" required>
                                </div>
                                <div class="col-md-4"></div>

                                @for ($i = 1; $i < 4; $i++) <div class="col-md-3 col-form-label">
                                    Sertifikat Vaksin {{ $i }}
                            </div>
                            <div class="col-md-5 my-1">
                                <div class="btn btn-default btn-sm btn-block btn-file border-dark w-100 p-1">
                                    <input type="hidden" name="foto_vaksin_{{ $i }}[]" value="" class="image-atk w-100">
                                    <input id="vaksin{{ $key.$i }}" type="file" name="foto_vaksin_{{ $i }}[]" class="image-atk w-100" accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            @endfor
                        </div>
                        @endforeach
                    </div>
            </div>
            <div class="form-group pt-5">
                <div class="row">
                    <div class="col-md-6 col-6 text-left">
                        <a href="javascript:void(0);" onclick="goBack()" class="btn btn-default border-dark text-dark">
                            <i class="fa-solid fa-square-caret-left"></i> Sebelumnya
                        </a>
                    </div>
                    <div class="col-md-6 col-6 text-right">
                        <button type="submit" class="btn btn-default border-dark text-dark" onclick="confirmBook(event, 'Selesai', 'Mohon periksa kembali, karena data yang sudah di kirim tidak bisa diubah atau dihapus')">
                            <i class="fa-solid fa-circle-check"></i> Selesai
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        @endif
    </div>
</div>
</div>

@section('js')

<script>
    $(function() {
        $('#btn-identitas').on('click', function() {
            $('#identitas').addClass('d-none')
            $('#bus').removeClass('d-none').addClass('d-block')
        })
    })
</script>

<script>
    function confirmBook(event, title, text) {
        event.preventDefault(); // Mencegah perilaku link bawaan

        // Mengecek setiap input pada formulir
        const form = document.getElementById('form');
        const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
        let isFormValid = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = 'red';
                isFormValid = false;

                Swal.fire({
                    title: 'Gagal',
                    text: 'Anda belum melengkapi kolom',
                    icon: 'error',
                });

                if (input.type === 'file') {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Anda belum upload file ' + input.name,
                        icon: 'error',
                    });
                }
            } else {
                input.style.borderColor = '';
            }
        });

        var seatTotal = '{{ $seatTotal }}'
        const fileImage = document.getElementById('fileImage');

        if (fileImage) {
            const fileImageSize = fileImage.files[0] ? fileImage.files[0].size : '';
            const allowedTypes = ['image/jpeg', 'image/png'];
            if (fileImage) {
                if (fileImageSize > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'File foto harus kurang dari 5 MB',
                        icon: 'error',
                    });
                    isFormValid = false;
                } else if (!allowedTypes.includes(fileImage.files[0].type)) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Tipe file foto harus jpg atau png',
                        icon: 'error',
                    });
                    isFormValid = false;
                }
            }
        }

        for (let key = 0; key < seatTotal; key++) {
            for (let i = 1; i < 4; i++) {
                const fileInput = document.getElementById('vaksin' + key + i);

                if (fileInput) {
                    const fileSize = fileInput.files[0] ? fileInput.files[0].size : '';
                    const allowedTypes = ['image/jpeg', 'image/png'];
                    if (fileSize) {
                        if (fileSize > 5 * 1024 * 1024) {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'File foto harus kurang dari 5 MB',
                                icon: 'error',
                            });
                            isFormValid = false;
                            break; // Keluar dari perulangan jika validasi gagal untuk salah satu input
                        } else if (!allowedTypes.includes(fileInput.files[0].type)) {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Tipe file foto harus jpg atau png',
                                icon: 'error',
                            });
                            isFormValid = false;
                            break; // Keluar dari perulangan jika validasi gagal untuk salah satu input
                        }
                    }
                }
            }
        }

        // Memeriksa validitas akhir setelah perulangan
        if (isFormValid) {
            // Menampilkan kotak dialog konfirmasi
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mengirim formulir jika dikonfirmasi
                    form.submit();
                }
            });
        }
    }
</script>

<script>
    function goBack() {
        window.history.back();
    }

    $(document).ready(function() {
        // Tambahkan event listener untuk menangkap perubahan tab
        $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
            // Hapus kelas active dari semua tab
            $('a[data-toggle="pill"]').removeClass('active bg-info');

            // Tambahkan kelas active ke tab yang sedang aktif
            $(e.target).addClass('active bg-info');
        });
    });


    $(document).ready(function() {
        $('.seat-checkbox').change(function() {
            var checkedCount = $('.seat-checkbox:checked').length;
            console.log(checkedCount)
            if (checkedCount > 5) {
                $(this).prop('checked', false);

                Swal.fire({
                    text: "Anda hanya dapat memilih maksimal 5 kursi.",
                    icon: 'error',
                });
            } else {
                $(this).data('count', checkedCount);
                if ($(this).is(':checked')) {
                    $(this).parent().css('background-color', 'red');
                } else {
                    $(this).parent().css('background-color', ''); // Reset warna jika checkbox tidak dicentang
                }
            }
        });
    });
</script>

<script>
    // When the document is ready
    $(document).ready(function() {
        $('#ruteSelect').change(function() {
            var selectedRuteId = $(this).val();

            $.ajax({
                url: '/tujuan/select/' + selectedRuteId,
                type: 'GET',
                success: function(data) {
                    $('#destSelect').empty();
                    $.each(data, function(key, val) {
                        $('#destSelect').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
        $('#utamaSelect').change(function() {
            var selectedUtamaId = $(this).val();

            $.ajax({
                url: '/uker/select/' + selectedUtamaId,
                type: 'GET',
                success: function(data) {
                    $('#ukerSelect').empty();
                    $.each(data, function(key, val) {
                        $('#ukerSelect').append('<option value="' + val.id + '">' + val.text + '</option>');
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

@endsection

@endsection

<!-- btn finish -->
<!-- <button type="submit" class="btn btn-secondary text-dark">
    Selanjutnya <i class="fa-solid fa-square-caret-right"></i>
</button> -->
