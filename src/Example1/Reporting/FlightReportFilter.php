<?php declare(strict_types=1);

namespace Example1\Reporting;

use DateTime;
use Example1\Entity\Flight;

class FlightReportFilter
{
    /**
     * @param FlightsByAircraft[] $flightsByAircraft
     * @return FlightsByAircraft[]
     */
    public function filterByAircraftIataCode(string $iataCode, array $flightsByAircraft): array
    {
        return array_filter(
            $flightsByAircraft,
            static function (FlightsByAircraft $group) use ($iataCode) {
                return $group->getAircraft()->getIataCode() === $iataCode;
            }
        );
    }

    /**
     * @param FlightsByAircraft[] $flightsByAircraft
     * @return FlightsByAircraft[]
     */
    public function filterByDate(?DateTime $from, ?DateTime $to, array $flightsByAircraft): array
    {
        return array_map(
            static function (FlightsByAircraft $group) use ($to, $from) {
                $flights = $group->getFlights();

                if ($from !== null) {
                    $flights = array_filter(
                        $flights,
                        static function (Flight $flight) use ($from) {
                            return $flight->getScheduledDate() >= $from;
                        }
                    );
                }

                if ($to !== null) {
                    $flights = array_filter(
                        $flights,
                        static function (Flight $flight) use ($to) {
                            return $flight->getScheduledDate() < $to;
                        }
                    );
                }

                return new FlightsByAircraft($group->getAircraft(), $flights);
            },
            $flightsByAircraft
        );
    }
}