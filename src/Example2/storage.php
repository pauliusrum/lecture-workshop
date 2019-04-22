<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Example2\Entity\FuelFilling;
use Example2\Entity\FuelStorage;
use Example2\Fillings\FuelFillingsAggregator;
use Example2\Fillings\FuelFillingsFilter;
use Example2\Fillings\FuelFillingsValidator;
use Example2\Storage\FuelStorageFormatter;
use Example2\Storage\FuelStorageTransformer;
use Util\ArgumentParser;
use Util\CsvFileParser;
use Util\FileStorage;
use Util\ShutdownHandler;

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
$shutdownHandler = new ShutdownHandler();
$argumentParser = new ArgumentParser($argv);
$csvFileParser = new CsvFileParser();
$fuelStorageTransformer = new FuelStorageTransformer();
$fuelFillingsAggregator = new FuelFillingsAggregator();
$fuelFillingsFilter = new FuelFillingsFilter();
$fuelFillingsValidator = new FuelFillingsValidator();
$fuelStorageFormatter = new FuelStorageFormatter();

// Load data from file
/** @var FuelStorage[] $fuelStorages */
$fuelStorages = $fileStorage->load(FuelStorage::class);
/** @var FuelFilling[] $fuelFillings */
$fuelFillings = $fileStorage->load(FuelFilling::class);

// Create storages from file
$config = $argumentParser->parseString('file');
if ($config !== null) {
    $fuelStoragesFromCsv = $csvFileParser->parse('config.csv');
    $fuelStorages = $fuelStorageTransformer->fromArray($fuelStoragesFromCsv);
}

/** @var int $storageId */
$storageId = $shutdownHandler->exitIfRuntimeErrorOccurs(static function () use ($argumentParser): ?int {
    return $argumentParser->parseInt('storage-id');
});
if ($storageId !== null) {
    // Find fuel storage by id
    if (!isset($fuelStorages[$storageId])) {
        $shutdownHandler->exitWithError("Storage with id $storageId does not exist.", 2);
    }

    $fuelStorage = $fuelStorages[$storageId];
    $storageFillings = $fuelFillingsFilter->filterByStorage($storageId, $fuelFillings);
    $currentAmount = $fuelFillingsAggregator->totalFuel($storageFillings);
    $capacity = $fuelStorage->getCapacity();

    $fillingAmount = $shutdownHandler->exitIfRuntimeErrorOccurs(static function () use ($argumentParser): ?int {
        return $argumentParser->parseInt('amount');
    });
    if ($fillingAmount !== null) {
        // Validate if the filling can be applied
        if ($fillingAmount < 0) {
            if (!$fuelFillingsValidator->isEnoughFuelInStorage($currentAmount, abs($fillingAmount))) {
                $shutdownHandler->exitWithMessage("There is not enough fuel in the storage. Current amount of fuel is {$currentAmount}l. Trying to empty {$fillingAmount}l.");
            }
        } else {
            if ($fuelFillingsValidator->willStorageOverflow($capacity, $currentAmount, $fillingAmount)) {
                $shutdownHandler->exitWithMessage("The storage will overflow. Current amount of fuel is {$currentAmount}l. Trying to fill {$fillingAmount}l. Maximum capacity is {$capacity}l.");
            }
        }

        // Add new filling
        $fillingId = count($fuelFillings);
        $filling = new FuelFilling($fillingId, $storageId, $fillingAmount, new DateTime());

        $storageFillings[] = $filling;
        $fuelFillings[] = $filling;
    }

    // Print storage information
    echo $fuelStorageFormatter->totalAmountAndFillings($fuelStorage, $currentAmount, $storageFillings);
} else {
    // Group fillings by storage
    $fillingsByStorage = $fuelFillingsAggregator->groupByStorage($fuelFillings);

    // Print all storages information
    $fuelStorageLines = [];
    foreach ($fuelStorages as $fuelStorage) {
        $storageFillings = $fillingsByStorage[$fuelStorage->getId()] ?? [];
        $currentAmount = $fuelFillingsAggregator->totalFuel($storageFillings);
        $fuelStorageLines[] = $fuelStorageFormatter->totalAmountAndFillings($fuelStorage, $currentAmount, $storageFillings);
    }

    echo implode("\n", $fuelStorageLines);
}

// Save data to file
$fileStorage->save(FuelStorage::class, $fuelStorages);
$fileStorage->save(FuelFilling::class, $fuelFillings);