<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buku Tamu</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/main.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-light bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">


        @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ Session::get("success") }}',
            });
        </script>
        @elseif (Session::has('pending'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: '{{ Session::get("pending") }}',
            });
        </script>
        @elseif (Session::has('failed'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ Session::get("failed") }}',
            });
        </script>
        @endif

        @yield('content')

    </div>
</body>

<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
@yield('js')
<script>
    function confirmSubmit(event, title, text) {
        event.preventDefault(); // Prevent the default link behavior

        // Mengecek setiap input pada form
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
                title: title,
                text: text,
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
                title: '',
                text: 'Seluruh kolom harus diisi',
                icon: 'error',
            });
        }
    }


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

</html>
