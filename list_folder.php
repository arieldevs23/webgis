<?php
$dataDir = __DIR__ . '/data';
$folders = array_filter(glob($dataDir . '/*'), 'is_dir');
$folderNames = array_map('basename', $folders);
header('Content-Type: application/json');
echo json_encode($folderNames);
