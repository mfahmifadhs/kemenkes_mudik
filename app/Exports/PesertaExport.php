<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Auth;
use DB;

class PesertaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $data = Peserta::join('t_booking', 'id_booking', 'booking_id')
            ->join('t_trayek', 'id_trayek', 'trayek_id')
            ->join('t_trayek_detail', 'id_detail', 'tujuan_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->join('t_unit_utama', 'id_unit_utama', 'unit_utama_id')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY id_peserta) as no'),
                'id_peserta',
                'uker_id',
                'unit_utama_id',
                'nama_unit_kerja',
                'kode_booking',
                'nama_peserta',
                'usia',
                'nik',
                'bus_id',
                'kode_seat',
                'jurusan',
                'rute',
                'nama_kota',
                'foto_vaksin_1',
                'foto_vaksin_2',
                'foto_vaksin_3'
            );

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
                    $res = $data->where('approval_roum', null)
                           ->where('approval_uker', 'true');
                } else if ($this->status == 'succeed') {
                    $res = $data->where('approval_uker', 'true')
                           ->where('approval_roum', 'true');
                } else if ($this->status == 'rejected') {
                    $res = $data->where('approval_uker', 'false')
                           ->orWhere('approval_roum', 'false');
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
            $peserta->id_peserta,
            $peserta->nama_unit_kerja,
            '`' . $peserta->kode_booking,
            $peserta->nama_peserta,
            $peserta->usia,
            '`' . $peserta->nik,
            $peserta->bus_id,
            $peserta->kode_seat,
            $peserta->jurusan,
            $peserta->rute,
            $peserta->nama_kota,
            $peserta->foto_vaksin_1 ? '=HYPERLINK("' . asset('storage/files/vaksin_1/' . $peserta->foto_vaksin_1) . '","File-Vaksin-1")' : '',
            $peserta->foto_vaksin_2 ? '=HYPERLINK("' . asset('storage/files/vaksin_2/' . $peserta->foto_vaksin_2) . '","File-Vaksin-2")' : '',
            $peserta->foto_vaksin_3 ? '=HYPERLINK("' . asset('storage/files/vaksin_3/' . $peserta->foto_vaksin_3) . '","File-Vaksin-3")' : ''
        ];
    }

    public function headings(): array
    {
        return [
            [
                "NO", "ID", "UNIT KERJA", "TIKET", "NAMA PESERTA", "USIA", "NIK", "BUS", "SEAT", "JURUSAN", "RUTE", "TUJUAN", "VAKSIN 1", "VAKSIN 2", "VAKSIN 3"
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
