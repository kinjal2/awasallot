<?php
ini_set('max_execution_time', 0); // unlimited time
set_time_limit(0);
$couchDBUrl = 'http://admin:admin@10.154.3.99:5984';
$dbName = 'awas_document_new1';
$backupDir = __DIR__ . '/couchdb_backup_docs';

if (!is_dir($backupDir)) mkdir($backupDir, 0777, true);

$limit = 100; // batch size
$skip = 0;

while (true) {
    $allDocsUrl = "$couchDBUrl/$dbName/_all_docs?include_docs=true&limit=$limit&skip=$skip";
    $response = file_get_contents($allDocsUrl);
    $data = json_decode($response, true);

    if (empty($data['rows'])) break;

    foreach ($data['rows'] as $row) {
        $doc = $row['doc'];
        $docId = $doc['_id'];

        // Fetch attachments one by one
        if (isset($doc['_attachments'])) {
            foreach ($doc['_attachments'] as $filename => $info) {
                $attUrl = "$couchDBUrl/$dbName/" . rawurlencode($docId) . "/" . rawurlencode($filename);
                $attData = file_get_contents($attUrl);

                if ($attData === false) continue;

                $doc['_attachments'][$filename] = [
                    'content_type' => $info['content_type'],
                    'data' => base64_encode($attData)
                ];
            }
        }

        unset($doc['_rev']);

        $safeId = preg_replace('/[^\w\-]/', '_', $docId);
        file_put_contents("$backupDir/{$safeId}.json", json_encode($doc));

        echo "✅ Backed up: $docId\n";
    }

    $skip += $limit;

    // Free memory manually
    unset($data);
    gc_collect_cycles();
}

echo "🎉 Backup completed\n";