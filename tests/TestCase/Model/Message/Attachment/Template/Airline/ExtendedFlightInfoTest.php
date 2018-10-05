<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ExtendedFlightInfoTest extends AbstractTestCase
{
    public function testInvalidTravelClass(): void
    {
        $departureAirport = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $arrivalAirport = Airport::create('SLC', 'Salt Lake City')->setTerminal('T4')->setGate('G8');
        $flightSchedule = FlightSchedule::create('2016-01-02T19:45')->setArrivalTime('2016-01-02T21:20');

        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('travelClass must be either "economy, business, first_class".');
        $airlineExtendedFlightInfo = ExtendedFlightInfo::create('c001', 's001', 'KL9123', $departureAirport, $arrivalAirport, $flightSchedule, 'second_class');
    }
}
