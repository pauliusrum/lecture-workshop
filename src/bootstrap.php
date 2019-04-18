<?php declare(strict_types=1);

(static function () {
    require_once __DIR__ . '/../vendor/autoload.php';

    $outDir = __DIR__ . '/../out/';

    // Creates out directory for generated files
    !file_exists($outDir) && !mkdir($outDir) && !is_dir($outDir);
})();