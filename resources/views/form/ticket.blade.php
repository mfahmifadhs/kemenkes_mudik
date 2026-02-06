<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; }
        .ticket {
            border: 1px solid #e0e0e0;
            border-radius: 15px;
            background-color: #fff;
            position: relative;
        }
        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px dashed #bbb;
        }
        /* Lubang Tiket */
        .circle-left, .circle-right {
            position: absolute;
            top: 145px;
            width: 24px;
            height: 24px;
            background-color: #f4f4f4; /* Samakan dengan warna bg kertas luar */
            border-radius: 50%;
        }
        .circle-left { left: -12px; }
        .circle-right { right: -12px; }

        .content { padding: 20px; }

        .table-peserta {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .table-peserta th {
            background-color: #00a19d;
            color: #fff;
            padding: 8px;
            font-size: 11px;
        }
        .table-peserta td {
            border-bottom: 1px solid #eee;
            padding: 8px;
            font-size: 11px;
            text-align: center;
        }

        /* Styling Catatan */
        .notes-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff9e6; /* Kuning soft */
            border-radius: 10px;
            border-left: 4px solid #ffc107;
        }
        .notes-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            color: #856404;
        }
        .notes-list {
            margin: 0;
            padding-left: 15px;
            font-size: 10px;
            line-height: 1.4;
            color: #555;
        }
        .notes-list li { margin-bottom: 4px; }
    </style>
</head>
<body>

    <div class="ticket">
        <div class="circle-left"></div>
        <div class="circle-right"></div>

        <div class="header">
            <img src="{{ $logoBase64 }}" style="width: 140px;">
            <h2 style="margin: 10px 0 5px 0; color: #00a19d;">E-TIKET MUDIK 2026</h2>
            <div style="font-size: 14px; font-weight: bold;">KODE BOOKING: {{ $book->kode_booking }}</div>
        </div>

        <div class="content">
            <table width="100%" style="font-size: 12px; margin-bottom: 10px; border: 1px;">
                <tr>
                    <td width="20%" style="color: #888;">Nama Pegawai</td>
                    <td width="30%">: <strong>{{ $book->nama_pegawai }}</strong></td>
                    <td width="20%" style="color: #888;">Tujuan</td>
                    <td width="30%">: <strong>{{ $book->tujuan->nama_kota }}</strong></td>
                </tr>
                <tr>
                    <td width="20%" style="color: #888;">Unit Kerja</td>
                    <td width="30%" colspan="2">: <strong>{{ $book->uker->nama_unit_kerja }}</strong></td>
                </tr>
            </table>

            <table class="table-peserta">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Nama Peserta</th>
                        <th width="30%">NIK</th>
                        <th width="10%">Bus</th>
                        <th width="10%">Kursi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="text-align: left;">{{ $row->nama_peserta }}</td>
                        <td>{{ $row->nik }}</td>
                        <td>{{ $row->bus_id }}</td>
                        <td style="font-weight: bold; color: #00a19d;">{{ $row->kode_seat }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="notes-section">
                <div class="notes-title">SYARAT & KETENTUAN PENTING:</div>
                <ol class="notes-list">
                    <li>Peserta diharapkan menyimpan Kode Booking yang telah didapatkan.</li>
                    <li>Pendaftaran "Mudik Bersama Kemenkes" tidak dapat dibatalkan/diubah tanpa persetujuan panitia.</li>
                    <li><strong>Peserta wajib menyetorkan uang jaminan senilai Rp200.000</strong>, sebagai penjamin kepastian keberangkatan peserta.</li>
                    <li>Uang jaminan menjadi penjamin penumpang dapat mengikuti perjalanan.</li>
                    <li>Uang jaminan <strong>tidak dapat dikembalikan</strong>, apabila salah satu atau lebih peserta dan/atau keluarga peserta membatalkan keberangkatan.
                        <br><i>Contoh: Pegawai mendaftarkan 3 keluarga, namun 1 orang batal, maka uang jaminan hangus (tidak kembali).</i>
                    </li>
                </ol>
            </div>
        </div>
    </div>

</body>
</html>
