<?php declare(strict_types=1);

namespace Example1\Entity;

class Aircraft
{
    /** @var int */
    private $id;

    /** @var string */
    private $iataCode;

    public function __construct(int $id, string $iataCode)
    {
        $this->id = $id;
        $this->iataCode = $iataCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIataCode(): string
    {
        return $this->iataCode;
    }
}