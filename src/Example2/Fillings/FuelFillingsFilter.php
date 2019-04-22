<?php declare(strict_types=1);

namespace Example2\Fillings;

use Example2\Entity\FuelFilling;

class FuelFillingsFilter
{
    /**
     * @param int $storageId
     * @param FuelFilling[] $fillings
     * @return FuelFilling[] $fillings
     */
    public function filterByStorage(int $storageId, array $fillings): array
    {
        return array_filter(
            $fillings,
            static function (FuelFilling $filling) use ($storageId) {
                return $filling->getStorageId() === $storageId;
            }
        );
    }
}