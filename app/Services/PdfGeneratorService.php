<?php

namespace App\Services;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PdfGeneratorService
{
    public function generate($requestModel, $requestid, $rivision_id, $type, $outputMode = 'I')
    {
        $loginUid = Session::get('Uid');         // Logged-in user's UID
        $isAdmin = Session::get('is_admin');     // Check admin flag

        $data = $requestModel->getFormattedRequestData($requestid, $rivision_id);
       ///dd( $data['uid']);
        if ($data !== null && isset($data['uid'])) {
            if (!$isAdmin && $loginUid !== $data['uid']) {
            abort(403, "You do not have permission to access this user's data.");
            }
            $uid = $isAdmin ? $data['uid'] : $loginUid;

            } else {
            abort(403, "User data is not available.");
        }

        $imageData = generateImage($uid);
        $data['imageData'] = $imageData;

        $officecode = Session::get('officecode');
        $officecode = getOfficeByCode($officecode);
        $data['officesname'] = isset($officecode[0]->officesnameguj) ? $officecode[0]->officesnameguj : null;

        try {
            $fontDir = base_path('resources/fonts/');
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'fontDir' => $fontDir,
                'fontdata' => [
                    "shruti" => [
                        'R' => "shruti.ttf",
                        'B' => "shrutib.ttf",
                        'useOTL' => 0xFF,
                        'useKashida' => 75,
                    ],
                ],
                'default_font' => 'shruti',
            ]);

            $uid = (string) $uid;
            $mpdf->SetWatermarkText($uid);
            $mpdf->showWatermarkText = true;

            if($type === 'a') {
                $html = view('request/applicationview', $data)->render();
            } else {
                $html = view('request/applicationview_b', $data)->render();
            }

            $mpdf->WriteHTML($html);
            $fileName = $uid . '_' . Session::get('Name') . '.pdf';
            $storagePath = public_path("pdfs/{$uid}/");

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

        $fullPath = $storagePath . $fileName;
            $pdfContent = $mpdf->Output('', 'S');
            file_put_contents($fullPath, $pdfContent);

            if($outputMode == 'I') {
                $mpdf->Output($fileName, 'I');
            } elseif($outputMode == 'D') {
                $mpdf->Output($fileName, 'D');
            } elseif($outputMode == 'F') {
                return $fullPath;
            }

        } catch (\Mpdf\MpdfException $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            return null;
        }
    }
}
