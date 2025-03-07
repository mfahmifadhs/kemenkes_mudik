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
                <div style="font-size: 36px;font-weight: bold;">
                    <b>TIKET MUDIK</b>
                </div>
            </td>
            <td style="width: 30%;">
                <img src="https://i.ibb.co/crBsD6k/logo-kemenkes.png" style="width: 50%;">
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
                <h3 style="margin-left: 10px;"><b>JAKARTA - {{ strtoupper($tujuan) }}</b></h3>
                <h6 style="font-size: 12px;">{{ $rute }}</h6>
                <span style="font-size: 12px; font-weight: bold;">Keberangkatan Tanggal 27 Maret 2025 Pukul 08.00 WIB</span> <br>
                <span style="font-size: 12px; color: red;font-weight: bold;">Diharapkan berkumpul paling lambat 06.30 WIB</span> <br>
                <span style="font-size: 12px;">Contact Person : 0812-6337-1270 (Martin), 0852-3073-8280 (Desya), 0812-9120-2267 (Fajrin) </span>
                <!-- <table class="table mt-3" style="width: 100%;">
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
                </table> -->
            </td>
        </tr>
    </table>
    <hr>
    <h6>
        <span style="font-weight: bold;">Tiket ini diterima oleh</span> <br>
        {{ $pegawai }} <br>
        {{ $nip_nik }} <br>
        {{ $alamat }} <br>
        {{ $uker }}
        @if ($upt)
        <br> {{ $upt }}
        @endif
    </h6>
    <hr>
    <p style="font-weight: bold;">Detail Pendaftaran</p>
    <table style="width: 100%;">
        <thead>
            <tr style="border: 1px solid #000;">
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
            <tr style="border: 1px solid #000;">
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
            <td>1. </td>
            <td>Peserta diharapkan menyimpan Kode Booking yang telah didapatkan.</td>
        </tr>
        <tr>
            <td>2. </td>
            <td>Pendaftaran "Mudik Bersama Kemenkes" tidak dapat dibatalkan/diubah tanpa persetujuan panitia.</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">3. </td>
            <td>Peserta wajib menyetorkan uang jaminan senilai Rp200.000, sebagai penjamin kepastian keberangkatan peserta.
        </td>
        </tr>
        <tr>
            <td>4. </td>
            <td>Uang jaminan menjadi penjamin penumpang dapat mengikuti perjalanan.</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">5. </td>
            <td>Uang jaminan tidak dapat dikembalikan, apabila salah satu atau lebih peserta dan/atau keluarga peserta membatalkan keberangkatan<br>
                Contoh : Pegawai atas nama A, mendaftarkan 3 anggota keluarganya, namun salah satu anggota keluarganya membatalkan keberangkatan. Maka uang jaminan tidak dapat dikembalikan.</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">6. </td>
            <td><b>E-ticket ini harap ditunjukkan ke panitia untuk pengambilan uang jaminan pada saat waktu keberangkatan</b></td>
        </tr>
    </table>

</body>

</html>
