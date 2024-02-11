<?php

namespace App\Exports;

use App\Models\Bus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BusExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $no = 0;

    public function collection()
    {
        $data     = Bus::join('t_trayek', 'id_trayek', 'trayek_id')->get();
        return $data;
    }

    public function map($data): array
    {
        return [
            //data yang dari kolom tabel database yang akan diambil
            ++$this->no,
            $data->no_plat,
            $data->deskripsi,
            $data->jurusan,
            $data->rute,
            $data->total_kursi,
            $data->total_kursi - $data->detail->where('status', '!=', 'cancel')->count(),
            $data->detail->where('status', 'book')->count(),
            $data->detail->where('status', 'full')->count()
        ];
    }

    public function headings(): array
    {
        return [
            [
                "NO", "NO.MOBIL", "MERK TIPE", "JURUSAN", "RUTE", "TOTAL KURSI", "TOTAL TERSEDIA", "TOTAL DIPESAN", "TOTAL TERISI"
            ]
        ];
    }
}
