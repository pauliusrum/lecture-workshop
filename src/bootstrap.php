<?php declare(strict_types=1);

$outDir = __DIR__ . '/../out/';

require_once __DIR__ . '/../vendor/autoload.php';

// Creates out directory for generated files
!file_exists($outDir) && !mkdir($outDir) && !is_dir($outDir);