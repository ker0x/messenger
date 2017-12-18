<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AirlineUpdateTest extends AbstractTestCase
{

    public function testInvalidUpdateType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$updateType must be either delay, gate_change, cancellation');

        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('AMS', 'Amsterdam'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2015-12-26T11:30'))->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = new FlightInfo('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineUpdate = new AirlineUpdateTemplate('departure', 'en_US', 'CF23G2', $updateFlightInfo);
    }

}