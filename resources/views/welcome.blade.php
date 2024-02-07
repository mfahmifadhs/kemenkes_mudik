@extends('app')

@section('content')
<div class="max-w-7xl mx-auto p-6 lg:p-8">
    <div class="flex justify-center">
        <a href="{{ route('login') }}">
            <img src="{{ asset('dist/img/logo-kemenkes.png') }}" alt="kemenkes" width="1000">
        </a>
    </div>

    <div class="mt-16 flex items-center justify-center">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8 mx-2" style="width: 50%;">

            <a href="{{ route('form.create') }}" class="scale-100 p-6 dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-info-500" style="background-color: #2bbecf;">
                <div class="text-center">
                    <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fa-solid fa-bus fa-2x"></i>
                        <p>Daftar</p>
                        <small>Form Registrasi Mudik Bersama Kemenkes</small>
                    </h2>
                </div>
            </a>
            <a href="{{ route('tiket.check') }}" class="text-center text-primary"><u>Cek Pendaftaran</u></a>
        </div>
    </div>
</div>
@endsection


<!-- MAPPING KURSI BUS -->

<!-- @php
$jumlahSeat = 38;
$seatKiri = ['A', 'B'];
$seatKanan = ['C', 'D'];
@endphp

<div class="row">
    <div class="col-md-5">
        @for ($i = 1; $i <= $jumlahSeat; $i++) <div class="row">
            @foreach ($seatKiri as $kode)
            <div class="col-md-6">
                {{ $i . $kode }}
            </div>
            @endforeach
    </div>
    @endfor
</div>
<div class="col-md-5">
    @for ($i = 1; $i <= $jumlahSeat; $i++) <div class="row">
        @foreach ($seatKanan as $kode)
        <div class="col-md-6">
            {{ $i . $kode }}
        </div>
        @endforeach
</div>
@endfor
</div>
</div> -->
