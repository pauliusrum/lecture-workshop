<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Util\FileStorage;

/**
 * Storing objects into a file.
 *
 * To save objects into a file run:
 *
 *      $fileStorage->save(Example::class, $arrayOfObjects);
 *
 *
 * To load objects from file run:
 *
 *      $fileStorage->load(Example::class);
 */
$fileStorage = new FileStorage($outDir);

// To get console arguments use: $argv (https://www.php.net/manual/en/reserved.variables.argv.php)
// Your code goes here...