<?php declare(strict_types=1);

namespace Example1\Report;

use DateTimeInterface;
use Example1\Entity\Aircraft;
use Example1\Entity\Flight;

class FlightReportGenerator
{
    /** @var string */
    private const DateFormat = 'Y-m-d';

    /** @var string */
    private $outputDir;

    public function __construct(string $outputDir)
    {
        $this->outputDir = rtrim($outputDir, '/');
    }

    /**
     * @param Flight[] $flights
     * @param Aircraft[] $aircrafts
     */
    public function generate(DateTimeInterface $from, DateTimeInterface $to, array $flights, array $aircrafts): void
    {
        $reportName = "Flight-report--{$from->format(self::DateFormat)}-{$to->format(self::DateFormat)}.html";

        $html = '<html>';
        $html .= '<head>';
        $html .= '<style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 6px; }</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<table>';
        $html .= '<tr><th>Aircraft</th><th colspan="100%">Flights</th></tr>';
        foreach ($aircrafts as $aircraft) {
            $html .= '<tr>';
            $html .= "<th>{$aircraft->getIataCode()}</th>";
            foreach ($flights as $flight) {
                $flightDate = $flight->getScheduledDate();
                if ($flightDate >= $from && $flightDate < $to && $flight->getAircraftId() === $aircraft->getId()) {
                    $html .= "<td>{$flight->getFlightNumber()} @ {$flight->getScheduledDate()->format('Y-m-d H:i:s')}</td>";
                }
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '</body>';
        $html .= '</html>';

        file_put_contents("{$this->outputDir}/$reportName", $html);
    }
}