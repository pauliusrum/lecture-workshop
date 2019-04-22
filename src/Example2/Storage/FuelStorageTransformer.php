<?php declare(strict_types=1);

namespace Example2\Storage;

use Example2\Entity\FuelStorage;
use RuntimeException;

class FuelStorageTransformer
{
    /**
     * @param FuelStorage[] $items
     * @return array
     */
    public function fromArray(array $items): array
    {
        return array_map(
            function (array $item): FuelStorage {
                $id = $this->requireDigit($item[0]);
                $name = $item[1];
                $capacity = $this->requireDigit($item[2]);

                return new FuelStorage($id, $name, $capacity);
            },
            $items
        );
    }

    private function requireDigit(string $value): int
    {
        if (!ctype_digit($value)) {
            throw new RuntimeException("The given value '$value'' is not a digit.");
        }

        return (int)$value;
    }
}