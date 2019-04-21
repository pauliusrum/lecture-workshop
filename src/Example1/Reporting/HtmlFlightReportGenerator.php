<?php declare(strict_types=1);

namespace Example1\Reporting;

class HtmlFlightReportGenerator
{
    /**
     * @param FlightsByAircraft[] $flightsByAircraft
     * @return String
     */
    public function generate(array $flightsByAircraft): String
    {
        $aircraftItems = [];
        foreach ($flightsByAircraft as $group) {
            $flights = [];
            foreach ($group->getFlights() as $flight) {
                $flights[] = "<li>{$flight->getFlightNumber()} @ {$flight->getScheduledDate()->format('Y-m-d')}</li>";
            }

            $aircraftCode = $group->getAircraft()->getIataCode();
            $htmlFlights = implode($flights);

            $aircraftItems[] = <<<HTML
                <li>$aircraftCode
                    <ul>
                        $htmlFlights
                    </ul>   
                </li>
                HTML;
        }

        $htmlAircraftItems = implode($aircraftItems);

        return <<<HTML
            <html>
            <body>
            <h3>Flights by aircraft</h3>
            <ul>
                $htmlAircraftItems
            </ul>
            </body>
            </html>
            HTML;
    }
}