<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AirlineUpdateTest extends AbstractTestCase
{
    public function testInvalidUpdateType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('updateType must be either "delay, gate_change, cancellation".');

        $departureAirport = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam')->setTerminal('T4')->setGate('G8');
        $flightSchedule = FlightSchedule::create('2015-12-26T11:30')->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = FlightInfo::create('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineUpdate = AirlineUpdateTemplate::create('departure', 'en_US', 'CF23G2', $updateFlightInfo);
    }
}
