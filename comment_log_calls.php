<?php

$directory = new RecursiveDirectoryIterator(__DIR__ . '/app');
$iterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file) {
    $filepath = $file[0];
    $originalCode = file_get_contents($filepath);
    
    // Regex to find log calls (info, error, debug, etc.)
    $pattern = '/Log::(info|error|debug|warning|alert|notice|critical|emergency)\s*\([^;]*\);/';
    
    // Commenting out the log lines
    $newCode = preg_replace_callback($pattern, function ($matches) {
        // Add comment marks to each log line
        return "// " . $matches[0]; // Comment the entire matched log line
    }, $originalCode);

    // If changes were made, save the new content to the file
    if ($newCode !== $originalCode) {
        // Backup the original file before modification
        $backupPath = $filepath . '.bak';
        copy($filepath, $backupPath);

        file_put_contents($filepath, $newCode);
        echo "✅ Commented out Log call: {$filepath} (Backup saved: {$backupPath})\n";
    }
}
