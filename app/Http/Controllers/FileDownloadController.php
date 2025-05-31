<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Couchdb\Couchdb;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;


class FileDownloadController extends Controller
{
    public function download($filename)
    {  
        $filePath = public_path("downloads/{$filename}");
        if (file_exists($filePath)) {
            return Response::download($filePath, $filename, [
                'Content-Length: ' . filesize($filePath)
            ]);
        } else {
            abort(404);
        }
    }
    public function showDoc($filename)
    {       
            $doc_id = $filename;
            $extended = new Couchdb(URL_COUCHDB, USERNAMECD, PASSWORDCD);
            $extended->InitConnection();
            $status = $extended->isRunning();

            // Fetch the document from CouchDB
            $getDocument = $extended->getDocument(DATABASE, $doc_id);
            $couchDbResponse = json_decode($getDocument, true);

            if (isset($couchDbResponse['_attachments'])) {
                $attachments = $couchDbResponse['_attachments'];
            } else {
                return "Document Not Found!";
            }

            foreach ($attachments as $key => $value) {
                // Fetch the file content
                $getFileContent = file_get_contents(COUCHDB_DOWNLOADURL . "/" . DATABASE . "/" . $doc_id . "/" . $key);
                $contentType = $value['content_type'];

                if ($getFileContent) {
                    // Create a response with the correct headers to force the file to open in a new tab
                    // code to print pdf without watermark
                    // return response($getFileContent, 200)
                    //     //->header('Content-Type', $contentType)
                    //     ->header('Content-Type', 'application/pdf')
                    //     ->header('Content-Disposition', 'inline; filename="' . $key . '"');



                             // Save original PDF temporarily
                            $tempPath = storage_path('app/temp_original.pdf');
                            file_put_contents($tempPath, $getFileContent);

                            // Create mPDF instance
                            $mpdf = new Mpdf([
                                'mode' => 'utf-8',
                                'format' => 'A4',
                            ]);

                            // Set watermark
                            $uid = explode('_', $doc_id)[0];
                            $mpdf->SetWatermarkText($uid);
                            $mpdf->showWatermarkText = true;

                            // Import and apply watermark to each page
                            $pageCount = $mpdf->SetSourceFile($tempPath);
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $templateId = $mpdf->ImportPage($i);
                                $mpdf->AddPage();
                                $mpdf->UseTemplate($templateId);
                            }

                            // Return PDF as browser response
                            $output = $mpdf->Output('', Destination::STRING_RETURN);
                            unlink($tempPath); // clean up temp file

                            return response($output, 200)
                                ->header('Content-Type', 'application/pdf')
                                ->header('Content-Disposition', 'inline; filename="' . $key . '"');

                                    } else {
                                        return "Error fetching the document";
                                    }
                                }
    }
   
}
