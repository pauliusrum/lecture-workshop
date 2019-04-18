<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Util\ArgumentParser;
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
 * *) To load objects from file run:
 *
 *    $fuelStorages = $fileStorage->load(FuelStorage::class);
 *
 *    NOTE: if nothing was stored an empty array will be returned.
 */
$fileStorage = new FileStorage($outDir);

/**
 * Command: php storage.php name="Storage name" date="2018-01-01" amount=100
 *
 * *) To parse the name run:
 *
 *    $name = $argumentParser->parseString('name')
 *
 * *) To parse the date run:
 *
 *    $date = $argumentParser->parseDateTime('date', 'Y-m-d');
 *
 * *) To parse the int run:
 *
 *    $amount = $argumentParser->parseDateTime('amount');
 */
$argumentParser = new ArgumentParser($argv);

// Your code goes here...