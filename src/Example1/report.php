<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Example1\Entity\Aircraft;
use Example1\Entity\Flight;
use Example1\Reporting\FlightReportAggregator;
use Example1\Reporting\FlightReportFilter;
use Example1\Reporting\HtmlFlightReportGenerator;
use Example1\Reporting\JsonFlightReportGenerator;
use Util\ArgumentParser;
use Util\ShutdownHandler;

/**
 * Aircraft(
 *    int $id,
 *    string $iataCode
 * )
 */
$aircrafts = [
    'L2T' => new Aircraft(1, 'L2T'),
    'A40' => new Aircraft(2, 'A40'),
];

/**
 * Flight(
 *    int $id,
 *    string $flightNumber,
 *    DateTime $scheduledDate,
 *    int $aircraftId
 * )
 */
$flights = [
    new Flight(1, 'X430', new DateTime('2019-01-01 10:30:00'), $aircrafts['A40']->getId()),
    new Flight(2, 'X230', new DateTime('2019-01-02 02:45:00'), $aircrafts['L2T']->getId()),
    new Flight(3, 'Y560', new DateTime('2019-01-02 12:00:00'), $aircrafts['A40']->getId()),
    new Flight(4, 'E780', new DateTime('2019-01-02 16:10:00'), $aircrafts['L2T']->getId()),
    new Flight(5, 'Z520', new DateTime('2019-01-03 10:30:00'), $aircrafts['L2T']->getId()),
];

$argumentParser = new ArgumentParser($argv);
$shutdownHandler = new ShutdownHandler();
$htmlReportGenerator = new HtmlFlightReportGenerator();
$jsonReportGenerator = new JsonFlightReportGenerator();
$flightReportAggregator = new FlightReportAggregator();
$flightReportFilter = new FlightReportFilter();

$generatedReportsDir = __DIR__ . '/../../out/';

// Aggregate data for report.
$reportData = $flightReportAggregator->groupByAircrafts($aircrafts, $flights);

// Filter by given aircraft iata code.
$aircraft = $argumentParser->parseString('aircraft');
if ($aircraft !== null) {
    $reportData = $flightReportFilter->filterByAircraftIataCode($aircraft, $reportData);
}

// Filter by given date range.
/** @var DateTime $from */
$from = $shutdownHandler->exitIfRuntimeErrorOccurs(static function () use ($argumentParser): ?DateTime {
    $date = $argumentParser->parseDateTime('from', 'Y-m-d');
    if ($date !== null) {
        $date->setTime(0, 0);
    }

    return $date;
});

/** @var DateTime $to */
$to = $shutdownHandler->exitIfRuntimeErrorOccurs(static function () use ($argumentParser): ?DateTime {
    $date = $argumentParser->parseDateTime('to', 'Y-m-d');
    if ($date !== null) {
        $date->setTime(0, 0);
    }

    return $date;
});

$reportData = $flightReportFilter->filterByDate($from, $to, $reportData);

// Generate report by the given format. Defaults to json.
$reportFormat = $argumentParser->parseString('format') ?? 'json';
switch ($reportFormat) {
    case 'html':
        $reportContents = $htmlReportGenerator->generate($reportData);
        break;
    case 'json':
        $reportContents = $jsonReportGenerator->generate($reportData);
        break;
    default:
        $shutdownHandler->exitWithError("Format '$reportFormat' is not supported. Available formats: json, html.", 1);
}

// Print report to the given output. Defaults to screen.
$reportOutput = $argumentParser->parseString('output') ?? 'screen';
switch ($reportOutput) {
    case 'screen':
        echo $reportContents;
        break;
    case 'file':
        file_put_contents("${generatedReportsDir}report.$reportFormat", $reportContents);
        break;
    default:
        $shutdownHandler->exitWithError("Output '$reportOutput' is not supported. Available outputs: screen, file.", 2);
}