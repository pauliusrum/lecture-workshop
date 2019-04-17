<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

function createOutputDir(string $rootDir)
{
    $normalized = rtrim($rootDir, '/') . '/out';
    /** @noinspection MkdirRaceConditionInspection */
    !file_exists($normalized) && mkdir($normalized);
}