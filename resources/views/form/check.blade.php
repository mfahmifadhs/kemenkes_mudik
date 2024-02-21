@extends('app')

@section('content')

<div class="max-w-7xl mx-auto p-6 lg:p-8">
    <a href="{{ route('home') }}">
        <div class="flex justify-center">
            <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="500">
        </div>
    </a>

    <div class="mt-16 flex items-center justify-center">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8" style="width: 100%;">

            <a class="p-6 bg-white border border-dark via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20">
                <div>
                    <h6 class="mt-6 text-xl font-semibold text-gray-900 dark:text-black text-sm text-center">
                        <p>MASUKKAN KODE BOKING atau NIK/NIP</p>
                    </h6>

                    <p class="mt-3 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        <form id="form" action="{{ route('form.confirm.check') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg text-center rounded border border-dark number" name="kode" required>
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" class="btn btn-info text-dark border-dark" onclick="confirmSubmit(event, 'Cek', 'Cek Kode Boking')">
                                    <i class="fa-solid fa-magnifying-glass"></i> Check
                                </button>
                            </div>
                        </form>
                    </p>
                </div>
            </a>

        </div>
    </div>

    <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
            <div class="flex items-center gap-4">
                <a href="" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Biro Umum
                </a>
            </div>
        </div>

        <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
            Versi 1.0
        </div>
    </div>
</div>
@section('js')
<script>
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
