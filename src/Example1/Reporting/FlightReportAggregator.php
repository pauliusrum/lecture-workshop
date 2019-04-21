<?php declare(strict_types=1);

namespace Example1\Reporting;

use Example1\Entity\Aircraft;
use Example1\Entity\Flight;

class FlightReportAggregator
{
    /**
     * @param Aircraft[] $aircrafts
     * @param Flight[] $flights
     * @return FlightsByAircraft[]
     */
    public function groupByAircrafts(array $aircrafts, array $flights): array
    {
        $flightsByAircraft = [];
        foreach ($flights as $flight) {
            $flightsByAircraft[$flight->getAircraftId()][] = $flight;
        }

        $aircraftFlights = [];
        foreach ($aircrafts as $aircraft) {
            $aircraftFlights[] = new FlightsByAircraft($aircraft, $flightsByAircraft[$aircraft->getId()] ?? []);
        }

        return $aircraftFlights;
    }
}