<?php
ini_set('max_execution_time', 0);
set_time_limit(0);
// === CONFIGURATION ===
$couchDBUrl = 'http://admin:admin@10.154.3.153:5984';
$targetDB = 'awas_document_new1';
$backupDir = __DIR__ . '/couchdb_backup_docs';

// === STEP 1: Delete old DB if exists ===
$ch = curl_init("$couchDBUrl/$targetDB");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "🗑️  Deleted existing DB: $targetDB (if any)\n";

// === STEP 2: Create new DB ===
$ch = curl_init("$couchDBUrl/$targetDB");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
echo "📦 Created fresh DB: $targetDB\n";

// === STEP 3: Restore documents ===
$files = glob("$backupDir/*.json");
$count = 0;

foreach ($files as $file) {
    $docJson = file_get_contents($file);
    $doc = json_decode($docJson, true);
    $docId = $doc['_id'];

    $url = "$couchDBUrl/$targetDB/" . rawurlencode($docId);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $docJson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($docJson)
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status >= 200 && $status < 300) {
        echo "✅ Restored: $docId\n";
        $count++;
    } else {
        echo "❌ Failed: $docId (HTTP $status)\n";
    }
}

echo "🎉 Restore complete. $count documents inserted into $targetDB.\n";
