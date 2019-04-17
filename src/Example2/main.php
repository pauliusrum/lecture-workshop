<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Example2\Entity\FuelStorage;

$viewRenderer = new ViewRenderer(__DIR__ . '/View/');

$fuelStorages = [
    new FuelStorage(1, 'FS-1', 1200, 1500),
    new FuelStorage(2, 'FS-2', 130, 1800)
];

$viewRenderer->render(
    'storages.phtml',
    ['storages' => $fuelStorages]
);