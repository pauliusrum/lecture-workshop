<?php declare(strict_types=1);

namespace Example1\Reporting;

use Example1\Entity\Aircraft;
use Example1\Entity\Flight;

class FlightsByAircraft
{
    /** @var Aircraft */
    private $aircraft;

    /** @var Flight[] */
    private $flights;

    public function __construct(Aircraft $aircraft, array $flights)
    {
        $this->aircraft = $aircraft;
        $this->flights = $flights;
    }

    public function getAircraft(): Aircraft
    {
        return $this->aircraft;
    }

    /**
     * @return Flight[]
     */
    public function getFlights(): array
    {
        return $this->flights;
    }
}