<?php declare(strict_types=1);

namespace Example2\Storage;

use Example2\Entity\FuelFilling;
use Example2\Entity\FuelStorage;

class FuelStorageFormatter
{
    /**
     * @param FuelStorage $storage
     * @param FuelFilling[] $fillings
     * @return string
     */
    public function totalAmountAndFillings(FuelStorage $storage, int $currentAmount, array $fillings): string
    {
        $fillings = array_map(
            static function (FuelFilling $filling): string {
                return "{$filling->getAmount()}l @ {$filling->getAt()->format('Y-m-d H:i:s')}";
            },
            $fillings
        );

        $fillingsLines = implode("\n", $fillings) . "\n";

        return "{$storage->getName()}: {$currentAmount}l / {$storage->getCapacity()}l.\n$fillingsLines";
    }
}