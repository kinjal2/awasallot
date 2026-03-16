<?php

namespace App\Imports;

use App\Premise;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PremiseImport implements ToModel, WithStartRow
{
    private $batchId;
    private $quartertype;

    public function __construct($batchId, $quartertype)
    {
        $this->batchId = $batchId;
        $this->quartertype = $quartertype;
    }
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {

        // check if row is empty
        if (count($row) <= 1) {
            throw new \Exception('Beneficiary sheet is blank.');
        }
        if ((trim($row[0] ?? '') == '') && (trim($row[1] ?? '') == '')) {
            return null;
        }
        return new Premise([
            'batch_id' => $this->batchId,
            // 'srno' => $row['srno'],
            // 'premise_no' => $row['premisehousesflat_no'],
            'srno' => $row[0],
            'premise_no' => $row[1],
            'quarter_type' => $this->quartertype
        ]);
    }
}
