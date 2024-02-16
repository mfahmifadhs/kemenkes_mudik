<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: Arial;">
    <table>
        <tr>
            <td class="mt-2" style="width: 70%;">
                <div style="font-size: 36px;">
                    Tiket Mudik
                </div>
            </td>
            <td style="width: 30%;">
                <img src="https://i.ibb.co/DKyrFb8/logo-kemenkes.png" style="width: 50%;">
            </td>
        </tr>
    </table>
    <table class="table mt-1">
        <tr>
            <td style="width: 30%;vertical-align: top;">
                <h3>Tiket ID</h3>
                <h1><b>{{ $kode_book }}</b></h1>
            </td>
            <td style="width: 50%;">
                <h3 style="margin-left: 10px;"><b>{{ $jurusan }} - {{ strtoupper($tujuan) }}</b></h3>
                <h6 style="font-size: 12px;">{{ $rute }}</h6>
                <table class="table mt-3" style="width: 100%;">
                    <tr>
                        <td>
                            <small>{{ $jurusan }} - {{ strtoupper($tujuan) }}</small> <br>
                            <small>13 April 2024</small> <br>
                            <small>14.00</small>
                        </td>
                        <td>
                            <small>{{ strtoupper($tujuan) }} - {{ $jurusan }}</small> <br>
                            <small>13 April 2024</small> <br>
                            <small>14.00</small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <p>Detail Pesanan</p>
    <table class="table table-bordered table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Usia</th>
                <th>NIK</th>
                <th>Bus</th>
                <th>Nomor Kursi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $index => $peserta)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $peserta->nama_peserta }}</td>
                <td>{{ $peserta->usia }}</td>
                <td>{{ $peserta->nik }}</td>
                <td>{{ $peserta->bus_id }}</td>
                <td>{{ $peserta->kode_seat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <p class="font-weight-bold">Catatan</p>
    <table>
        <tr>
            <td>◾</td>
            <td>Peserta diharapkan menyimpan Kode Booking yang telah didapatkan.</td>
        </tr>
        <tr>
            <td>◾</td>
            <td>Pendaftaran "Mudik Bersama Kemenkes" tidak dapat Dibatalkan/diubah tanpa persetujuan panitia.</td>
        </tr>
        <tr>
            <td>◾</td>
            <td>Selanjutnya akan dilakukan verifikasi oleh PIC Mudik Bersama Kemenkes pada masing-masing Sekretariat Unit Utama atau Subbagian Administrasi Umum pada setiap unit eselon II bagi Unit Utama Sekretariat Jenderal.</td>
        </tr>
        <tr>
            <td>◾</td>
            <td>Kemudian akan dilakukan verifikasi akhir oleh Biro Umum.</td>
        </tr>
    </table>

</body>

</html>