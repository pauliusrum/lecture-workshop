<?php declare(strict_types=1);

namespace Util;

class CsvFileParser
{
    public function parse(string $csvFile): array
    {
        return array_map('str_getcsv', file($csvFile));
    }
}