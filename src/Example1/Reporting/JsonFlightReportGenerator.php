<?php declare(strict_types=1);

namespace Example1\Reporting;

class JsonFlightReportGenerator
{
    /**
     * @param FlightsByAircraft[] $flightsByAircraft
     * @return String
     */
    public function generate(array $flightsByAircraft): String
    {
        $normalized = [];

        foreach ($flightsByAircraft as $group) {
            $aircraftCode = $group->getAircraft()->getIataCode();

            $flights = [];
            foreach ($group->getFlights() as $flight) {
                $flights[] = "{$flight->getFlightNumber()} @ {$flight->getScheduledDate()->format('Y-m-d')}";
            }

            $normalized[$aircraftCode] = $flights;
        }

        return json_encode($normalized);
    }
}