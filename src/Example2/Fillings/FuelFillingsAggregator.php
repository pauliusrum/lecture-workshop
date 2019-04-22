<?php declare(strict_types=1);

namespace Example2\Fillings;

use Example2\Entity\FuelFilling;

class FuelFillingsAggregator
{
    /**
     * @param FuelFilling[] $fillings
     * @return int
     */
    public function totalFuel(array $fillings): int
    {
        /** @var int $total */
        $total = array_reduce(
            $fillings,
            static function (int $total, FuelFilling $filling): int {
                return $total + $filling->getAmount();
            },
            0
        );

        return $total;
    }

    /**
     * @param FuelFilling[] $fillings
     * @return FuelFilling[]
     */
    public function groupByStorage(array $fillings): array
    {
        $groupedByStorage = [];
        foreach ($fillings as $filling) {
            $groupedByStorage[$filling->getStorageId()][] = $filling;
        }

        return $groupedByStorage;
    }
}