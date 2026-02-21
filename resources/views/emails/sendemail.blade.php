<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>E-Ticket Mudik Kemenkes</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; color: #444; line-height: 1.6; background-color: #f4f4f4; margin: 0; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e1e1e1; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <div style="background-color: #00a19d; padding: 25px; text-align: center;">
            <img src="https://i.ibb.co/crBsD6k/logo-kemenkes.png" width="120" style="filter: brightness(0) invert(1);">
            <h2 style="color: #ffffff; margin: 15px 0 0 0; font-size: 20px; letter-spacing: 1px;">E-TICKET MUDIK 2026</h2>
        </div>

        <div style="padding: 30px;">
            <p style="margin-top: 0; font-weight: bold; color: #00a19d; font-size: 16px;">
                Selamat! Anda Telah Terdaftar Menjadi Peserta Mudik Bersama Kemenkes.
            </p>

            <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px;">
                <tr>
                    <td style="padding: 8px 0; color: #888; width: 130px;">Nama Pegawai</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #333;">{{ $data['nama'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #888;">NIP/NIK</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; font-weight: 600; color: #333;">{{ $data['nip'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #888;">Unit Kerja</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; color: #333;">{{ $data['uker'] }}</td>
                </tr>
                @if (!empty($data['upt']))
                <tr>
                    <td style="padding: 8px 0; color: #888;">Nama UPT</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; color: #333;">{{ $data['upt'] }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 8px 0; color: #888;">Jumlah Peserta</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; color: #333;">{{ $data['peserta'] }} Orang</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #888;">Kota Tujuan</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; color: #00a19d; font-weight: bold;">{{ $data['tujuan'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #888;">Jurusan</td>
                    <td style="padding: 8px 5px; color: #333;">:</td>
                    <td style="padding: 8px 0; text-transform: capitalize; color: #333;">{{ strtolower($data['trayek']) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #888; vertical-align: top;">Rute</td>
                    <td style="padding: 8px 5px; color: #333; vertical-align: top;">:</td>
                    <td style="padding: 8px 0; color: #666; font-size: 13px; line-height: 1.4;">{{ $data['rute'] }}</td>
                </tr>
            </table>

            <div style="text-align: center; margin-top: 35px; margin-bottom: 20px;">
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Mohon klik tombol di bawah ini untuk mengunduh/mencetak tiket Anda:</p>
                <a href="{{ route('ticket.download', $data['id']) }}"
                    style="background-color: #00a19d; color: #ffffff; padding: 12px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; display: inline-block; font-size: 14px; box-shadow: 0 4px 6px rgba(0,161,157,0.2);">
                    📥 DOWNLOAD E-TIKET
                </a>
            </div>
        </div>

        <div style="background-color: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
            <p style="font-size: 12px; color: #999; margin: 0;">
                Terimakasih,<br>
                <strong>Panitia Mudik Bersama Kemenkes 2026</strong><br>
                Biro Umum Sekretariat Jenderal Kementerian Kesehatan RI
            </p>
        </div>
    </div>
</body>

</html>