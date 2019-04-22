<?php declare(strict_types=1);

namespace Example2\Fillings;

class FuelFillingsValidator
{
    public function willStorageOverflow(int $capacity, int $currentAmount, int $fillingAmount): bool
    {
        return $capacity < $currentAmount + $fillingAmount;
    }

    public function isEnoughFuelInStorage(int $currentAmount, int $emptyAmount): bool
    {
        return $currentAmount - $emptyAmount >= 0;
    }
}