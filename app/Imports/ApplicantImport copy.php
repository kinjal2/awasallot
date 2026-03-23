<?php

namespace App\Imports;

use App\Application;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ApplicantImport implements ToModel, WithStartRow
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
     //   dd($row);
      // check if row is empty
        if (count($row) <= 1) {
            throw new \Exception('Beneficiary sheet is blank.');
        }
     if ((trim($row[0] ?? '') == '') && (trim($row[1] ?? '') == '')) {
        return null;
    }
        return new Application([
            'batch_id' => $this->batchId,
            // 'sono' => $row['srno'],
            // 'appln_name' => $row['appln_name'],
            'sono' => $row[0],
            'appln_name' => $row[1],
            'quarter_type' => $this->quartertype
        ]);
    }
}