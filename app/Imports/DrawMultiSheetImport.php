<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ApplicantImport;
use App\Imports\PremiseImport;

class DrawMultiSheetImport implements WithMultipleSheets
{
    protected $batchId;
    protected $quartertype;

    public function __construct($batchId, $quartertype)
    {
        $this->batchId = $batchId;
        $this->quartertype = $quartertype;
    }

    public function sheets(): array
    {
        // return [
        //     'beneficiary' => new ApplicantImport($this->batchId, $this->quartertype),
        //     'premise' => new PremiseImport($this->batchId, $this->quartertype),
        // ];
         return [
            0 => new ApplicantImport($this->batchId, $this->quartertype),
            1 => new PremiseImport($this->batchId, $this->quartertype),
        ];
    }
}