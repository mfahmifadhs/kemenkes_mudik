<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $no = 0;

    public function collection()
    {
        $data     = Peserta::join('t_booking', 'id_booking', 'booking_id')
            ->join('t_trayek', 'id_trayek', 'trayek_id')
            ->join('t_trayek_detail', 'id_detail', 'tujuan_id')
            ->join('t_unit_kerja', 'id_unit_kerja', 'uker_id')
            ->get();

        return $data;
    }

    public function map($data): array
    {
        return [
            //data yang dari kolom tabel database yang akan diambil
            ++$this->no,
            $data->id_peserta,
            $data->nama_unit_kerja,
            '`'. $data->booking_id,
            $data->nama_peserta,
            $data->usia,
            '`'. $data->nik,
            $data->bus_id,
            $data->kode_seat,
            $data->jurusan,
            $data->rute,
            $data->nama_kota,
            $data->foto_vaksin_1 ? '=HYPERLINK("' . asset('storage/files/vaksin_1/' . $data->foto_vaksin_1) . '","File-Vaksin-1")' : '',
            $data->foto_vaksin_2 ? '=HYPERLINK("' . asset('storage/files/vaksin_2/' . $data->foto_vaksin_2) . '","File-Vaksin-2")' : '',
            $data->foto_vaksin_3 ? '=HYPERLINK("' . asset('storage/files/vaksin_3/' . $data->foto_vaksin_3) . '","File-Vaksin-3")' : ''
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
