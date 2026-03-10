<?php

namespace App\Exports;

use App\DrawResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DrawResultExport implements FromCollection, WithHeadings
{
    protected $batchId;

    public function __construct($batchId)
    {
        $this->batchId = $batchId;
    }

    public function collection()
    {
        return DrawResult::select(
                'id',
                'appln_name',
                'premise_no',
                'draw_date'
            )
            ->where('batch_id', $this->batchId)
            ->orderBy('id','asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'Applicant No',
            'Flat No',
            'Draw Date'
        ];
    }
}