<?php

namespace App\Exports;

use App\Models\DataNakes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataNakesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil semua data nakes
        return DataNakes::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Status',
            'Kontak',
            'Tanggal Masuk',
        ];
    }

    public function map($nakes): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $nakes->nama,
            $nakes->status,
            $nakes->contact,
            $nakes->admitted_date ? $nakes->admitted_date->format('d-m-Y') : '-',
        ];
    }
}
