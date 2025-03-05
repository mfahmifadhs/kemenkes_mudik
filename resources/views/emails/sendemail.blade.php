<!DOCTYPE html>
<html>
<head>
    <title>Kirim Email</title>
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>
<body class="m-3">
    <img src="https://i.ibb.co/crBsD6k/logo-kemenkes.png" width="100">
    <br>
    <b style="margin-left: 5px;"><i>Selamat Anda Telah Terdaftar Menjadi Peserta Mudik Bersama Kemenkes.</i></b>
    <table style="margin-left: 5px;">
        <tr>
            <td>Nama Pegawai</td>
            <td>:</td>
            <td>{{ $data['nama'] }}</td>
        </tr>
        <tr>
            <td>NIP/NIK</td>
            <td>:</td>
            <td>{{ $data['nip'] }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>{{ $data['uker'] }}</td>
        </tr>
        @if ($data['upt'])
        <tr>
            <td>Nama UPT</td>
            <td>:</td>
            <td>{{ $data['upt'] }}</td>
        </tr>
        @endif
        <tr>
            <td>Jumlah Peserta</td>
            <td>:</td>
            <td>{{ $data['peserta'] }}</td>
        </tr>
        <tr>
            <td>Kota Tujuan</td>
            <td>:</td>
            <td>{{ $data['tujuan'] }}</td>
        </tr>
        <tr style="text-transform: capitalize;">
            <td>Jurusan</td>
            <td>:</td>
            <td>{{ strtolower($data['trayek']) }}</td>
        </tr>
        <tr>
            <td>Rute</td>
            <td>:</td>
            <td>{{ $data['rute'] }}</td>
        </tr>
    </table>
    <p>
        Mohon klik link dibawah ini untuk mencetak <b>Tiket</b>: <br>
        <a href="{{ route('tiket', ['rand' => 'cetak', 'id' => $data['id']]) }}" style="color: blue;"><i><u>
            {{ encrypt('Link verifikasi data') }}
        </i></u></a>
    </p>

    <p>Terimakasih</p>
</body>
</html>
