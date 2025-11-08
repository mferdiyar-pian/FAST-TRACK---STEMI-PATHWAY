<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CodeStemiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No. Rekam Medis',
            'ID',
            'Status',
            'Start Time',
            'End Time',
            'Door To Balloon Time',
            'Duration',
            'Checklist',
            'Custom Message',
        ];
    }

    public function map($row): array
    {
        return [
            $row->medical_record_number,
            $row->id,
            $row->status,
            optional($row->start_time)->format('d-m-Y H:i:s'),
            optional($row->end_time)->format('d-m-Y H:i:s'),
            $row->door_to_balloon_time,
            $row->duration,
            is_array($row->checklist) ? implode(', ', $row->checklist) : $row->checklist,
            $row->custom_message,
        ];
    }
}
