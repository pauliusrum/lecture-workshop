<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Util\FileStorage;

/**
 * Storing objects into a file.
 *
 * *) To save objects into a file run:
 *
 *    $fuelStorages = [];
 *    $fileStorage->save(FuelStorage::class, $fuelStorages);
 *
 *    NOTE: will override anything that was stored before.
 *
 *
 * *) To load objects from file run:
 *
 *    $fuelStorages = $fileStorage->load(FuelStorage::class);
 *
 *    NOTE: if nothing was saved an empty array will be returned.
 */
$fileStorage = new FileStorage($outDir);

// To get console arguments use: $argv (https://www.php.net/manual/en/reserved.variables.argv.php)
// Your code goes here...