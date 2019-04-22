<?php declare(strict_types=1);

namespace Example2\Entity;

use DateTime;

class FuelFilling
{
    /** @var int */
    private $id;

    /** @var int */
    private $storageId;

    /** @var int */
    private $amount;

    /** @var DateTime */
    private $at;

    public function __construct(int $id, int $storageId, int $amount, DateTime $at)
    {
        $this->id = $id;
        $this->storageId = $storageId;
        $this->amount = $amount;
        $this->at = $at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStorageId(): int
    {
        return $this->storageId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAt(): DateTime
    {
        return $this->at;
    }
}