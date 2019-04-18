<?php declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

use Example1\Entity\Aircraft;
use Example1\Entity\Flight;

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

$generatedReportsDir = __DIR__ . '/../../out/';

// To get console arguments use: $argv (https://www.php.net/manual/en/reserved.variables.argv.php)

// Your code goes here...