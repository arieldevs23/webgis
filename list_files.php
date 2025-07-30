<?php
$folder = $_GET['folder'] ?? '';
$folderPath = __DIR__ . '/data/' . basename($folder);

$files = [];
if (is_dir($folderPath)) {
    foreach (glob("$folderPath/*.json") as $file) {
        $files[] = basename($file);
    }
}

header('Content-Type: application/json');
echo json_encode($files);
