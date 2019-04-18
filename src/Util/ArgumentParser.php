<?php declare(strict_types=1);

namespace Util;

use DateTime;
use RuntimeException;

class ArgumentParser
{
    /** @var array */
    private $namedArgs = [];

    public function __construct(array $args)
    {
        array_shift($args);

        foreach ($args as $arg) {
            $pair = explode('=', $arg);
            $this->namedArgs[$pair[0]] = $pair[1];
        }
    }

    public function parseDateTime(string $name, string $format): ?DateTime
    {
        $value = $this->namedArgs[$name] ?? null;
        if ($value === null) {
            return null;
        }

        $date = DateTime::createFromFormat($format, $value);

        if (!($date && $date->format($format) === $value)) {
            throw new RuntimeException("Invalid date time. Expected format: {$format}; given: $value.");
        }

        return $date;
    }

    public function parseInt(string $name): ?int
    {
        $value = $this->namedArgs[$name] ?? null;
        if ($value === null) {
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new RuntimeException("Invalid integer: $value.");
        }

        return (int)$value;
    }

    public function parseString(string $name): ?string
    {
        return $this->namedArgs[$name] ?? null;
    }
}