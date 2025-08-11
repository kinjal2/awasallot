<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

class ExcelExportController extends Controller
{
    public function export()
    {
        $fileName = 'sample_export.xlsx';
        $filePath = storage_path("app/public/{$fileName}");

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        $writer = new Writer();
        $writer->openToFile($filePath);

        $writer->addRow(Row::fromValues(['ID', 'Name', 'Email']));
        $data = [
            [1, 'Alice', 'alice@example.com'],
            [2, 'Bob', 'bob@example.com'],
            [3, 'Charlie', 'charlie@example.com'],
        ];
        foreach ($data as $row) {
            $writer->addRow(Row::fromValues($row));
        }
        $writer->close();

        $response = response()->download($filePath, $fileName)
            ->deleteFileAfterSend(true);

        $response->headers->set(
            'Content-Type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        return $response;
    }
}
