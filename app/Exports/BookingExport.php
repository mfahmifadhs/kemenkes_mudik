<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;
use DB;

class BookingExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $no = 0;

    protected $request;


    function __construct($request)
    {
        $this->utama  = $request['utama'];
        $this->uker   = $request['uker'];
        $this->rute   = $request['rute'];
        $this->tujuan = $request['tujuan'];
        $this->status = $request['status'];
    }

    public function collection()
    {
        $role = Auth::user()->role_id;
        $data = Booking::orderBy('id_booking', 'ASC')->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id');

        if ($this->utama || $this->uker || $this->rute || $this->tujuan || $this->status) {
            if ($this->utama) {
                $res  = $data->where('unit_utama_id', $this->utama);
            }

            if ($this->uker) {
                $res  = $data->where('uker_id', $this->uker);
            }

            if ($this->rute) {
                $res  = $data->where('trayek_id', $this->rute);
            }

            if ($this->tujuan && $this->rute) {
                $res  = $data->where('tujuan_id', $this->tujuan);
            }

            if ($this->status) {
                if ($this->status == 'verif_uker') {
                    $res = $data->where('approval_uker', null);
                } else if ($this->status == 'verif_roum') {
                    $res = $data->where('approval_roum', null)->where('approval_uker', 'true');
                } else if ($this->status == 'succeed') {
                    $res = $data->where('approval_uker', 'true')->where('approval_roum', 'true');
                } else if ($this->status == 'rejected') {
                    $res = $data->where('approval_uker', 'false')->orWhere('approval_roum', 'false');
                }
            }

        } else {
            $res    = $data;
        }

        if ($role == 4 && Auth::user()->uker->unit_utama_id == '46593') {
            $peserta = $res->where('uker_id', Auth::user()->uker_id)->get();
        } else if ($role == 4) {
            $peserta = $res->where('unit_utama_id', Auth::user()->uker->unit_utama_id)->get();
        } else {
            $peserta = $res->get();
        }

        return $peserta;
    }

    public function map($peserta): array
    {
        return [
            //data yang dari kolom tabel database yang akan diambil
            ++$this->no,
            $peserta->nama_unit_utama,
            $peserta->nama_unit_kerja,
            '`' . $peserta->kode_booking,
            $peserta->nama_pegawai,
            '`' . $peserta->nip_nik,
            $peserta->no_telp,
            $peserta->alamat,
            $peserta->email,
            $peserta->approval_uker,
            $peserta->approval_roum,
            $peserta->catatan,
            $peserta->foto_kk ? '=HYPERLINK("' . asset('storage/files/foto_kk/' . $peserta->foto_kk) . '","File-KK")' : '',
            $peserta->foto_ktp ? '=HYPERLINK("' . asset('storage/files/foto_ktp/' . $peserta->foto_ktp) . '","File-KTP")' : ''
        ];
    }

    public function headings(): array
    {
        return [
            [
                "NO", "UNIT UTAMA", "UNIT KERJA", "TIKET", "NAMA PEGAWAI", "NIP/NIK", "NO.TELP", "ALAMAT", "EMAIL", "VERIFY UKER", "VERIFY ROUM", "CATATAN", "FOTO KK", "FOTO KTP"
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'M2:O9999' => [
                'font' => ['color' => ['rgb' => '0000FF'], 'underline' => true],
            ],
        ];
    }
}
