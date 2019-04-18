<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Example1\Entity\Aircraft;
use Example1\Entity\Flight;
use Util\ArgumentParser;

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

/**
 * Command: php report.php date="2018-01-01"
 *
 * *) To parse the date run:
 *
 *    $date = $argumentParser->parseDateTime('date', 'Y-m-d');
 */
$argumentParser = new ArgumentParser($argv);

$generatedReportsDir = __DIR__ . '/../../out/';

// Your code goes here...

$data = [];

/** @var Aircraft $aircraft */
foreach($aircrafts as $aircraft){
    $temp = [];
    $temp['aircfaft'] = $aircraft;
    $temp['flights'] = [];

    /** @var Flight $flight */
    foreach($flights as $flight){
        if($flight->getAircraftId() === $aircraft->getId()) {
            $temp['flights'][] = $flight;
        }
    }
    $data[] = $temp;
}

$html = '<html>
<body>
<h3>Flights by aircraft</h3>
<ul>';

foreach ($data as $datum) {
    $html .= '<li>';
    /** @var Aircraft $datum['aircfaft'] */
    $html .= $datum['aircfaft']->getIataCode();
    if(!empty($datum['flights'])) {
        $html .= '<ul>';
        /** @var Flight $flight */
        foreach ($datum['flights'] as $flight) {
            $html .= '<li>' . $flight->getFlightNumber().' @ ' .$flight->getScheduledDate()->format('Y-m-d H:i:s').'</li>';
        }
        $html .= '</ul>';
    }
    $html .= '</li>';
}
$html .= '</ul></html>';

file_put_contents($generatedReportsDir."example1.html", $html);