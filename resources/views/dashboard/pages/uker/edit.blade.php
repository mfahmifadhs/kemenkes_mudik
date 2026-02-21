@extends('dashboard.layout.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <small>Edit Unit Kerja</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                        @if(Auth::user()->role_id == 1)
                        <li class="breadcrumb-item"><a href="{{ route('uker') }}">Daftar Unit Kerja</a></li>
                        @endif
                        <li class="breadcrumb-item active">Edit Unit Kerja</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <form id="form" action="{{ route('uker.update', $id) }}" method="POST">
                @csrf
                <div class="card w-100">
                    <div class="card-header">
                        <label class="mt-3">Edit Unit Kerja</label>
                        <hr>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Unit Utama*</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="utama_id" class="form-control">
                                        @foreach($utama as $row)
                                        <option value="{{ $row->id_unit_utama }}" <?php echo $uker->unit_utama_id == $row->id_unit_utama ? 'selected' : ''; ?>>
                                            {{ $row->nama_unit_utama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-md-3 col-form-label">Nama Unit Kerja*</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama_unit_kerja" placeholder="Nama unit kerja" value="{{ $uker->nama_unit_kerja }}" required>
                                </div>
                            </div>
                            <label class="col-md-3 col-form-label">Nama PIC*</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pic_nama" value="{{ $uker->pic_nama }}" required>
                                </div>
                            </div>
                            <label class="col-md-3 col-form-label">No. HP PIC*</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="pic_nohp" value="{{ $uker->pic_nohp }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div><br>
</div>

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');
        const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
        let isFormValid = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = 'red';
                isFormValid = false;
            } else {
                input.style.borderColor = '';
            }
        });

        if (isFormValid) {
            Swal.fire({
                title: 'Simpan Perubahan ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                title: 'Gagal',
                text: 'Pastikan seluruh kolom terisi',
                icon: 'error',
            });
        }
    }

    // Password
    $(document).ready(function() {
        $("#eye-icon-pass").click(function() {
            var password = $("#password");
            var icon = $("#eye-icon");
            if (password.attr("type") == "password") {
                password.attr("type", "text");
                icon.removeClass("fas fa-eye-slash").addClass("fas fa-eye");
            } else {
                password.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        $("#eye-icon-conf").click(function() {
            var password = $("#conf-password");
            var icon = $("#eye-icon");
            if (password.attr("type") == "password") {
                password.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                password.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    });
</script>
@endsection
@endsection
