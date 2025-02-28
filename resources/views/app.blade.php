<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mudik Bersama - Kemenkes</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Sono:wght@200;300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/font/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/owl.theme.default.min.css') }}">

    <link href="{{ asset('dist/css/templatemo-pod-talk.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand me-lg-5 me-0" href="/">
                    <img src="{{ asset('dist/img/logo-kemenkes.png') }}" class="logo-image img-fluid" alt="templatemo pod talk">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ Session::get("success") }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        @elseif (Session::has('failed'))
        <script>
            Swal.fire({
                icon: 'error',
                text: '{{ Session::get("failed") }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        @elseif (Session::has('pending'))
        <script>
            Swal.fire({
                icon: 'info',
                text: '{{ Session::get("pending") }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        @endif

        @yield('content')
    </main>

    <!-- JAVASCRIPT FILES -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
                var value = $(this).val().replace(/[^0-9]/g, '');
                // Format dengan menambahkan titik koma setiap tiga digit
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '');

                $(this).val(formattedValue);
            });
        });
    </script>
    <script>
        // Password
        $(document).ready(function() {
            $("#eye-icon-pass").click(function() {
                var password = $("#password");
                var icon = $("#eye-icon-pass");
                if (password.attr("type") == "password") {
                    password.attr("type", "text");
                    icon.removeClass("fas fa-eye").addClass("fas fa-eye-slash");
                } else {
                    password.attr("type", "password");
                    icon.removeClass("fas fa-eye-slash").addClass("fas fa-eye");
                }
            });
        });
    </script>

</body>

</html>
