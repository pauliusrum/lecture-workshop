<?php declare(strict_types=1);

namespace Util;

use DateTime;
use RuntimeException;

class ArgumentParser
{
    public static function parseDateTime(string $value, string $format): DateTime
    {
        $date = DateTime::createFromFormat($format, $value);

        if (!($date && $date->format($format) === $value)) {
            throw new RuntimeException("Invalid date time. Expected format: {$format}; given: $value.");
        }

        return $date;
    }

    public static function parseInt(string $value): int
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new RuntimeException("Invalid integer: $value.");
        }

        return (int)$value;
    }
}