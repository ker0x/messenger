<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Message\Attachment\Template\Airline;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use PHPUnit\Framework\TestCase;

class BoardingPassTest extends TestCase
{
    /**
     * @var BoardingPass
     */
    protected $boardingPass;

    public function setUp(): void
    {
        $departureAirport = Airport::create('JFK', 'New York')->setTerminal('T1')->setGate('D57');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam');
        $flightSchedule = FlightSchedule::create('2016-01-02T19:05')->setArrivalTime('2016-01-05T17:30');

        $flightInfo = FlightInfo::create('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $this->boardingPass = BoardingPass::create('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo);
    }

    public function testWithBarCode(): void
    {
        $departureAirport = Airport::create('JFK', 'New York')->setTerminal('T1')->setGate('D57');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam');
        $flightSchedule = FlightSchedule::create('2016-01-02T19:05')->setArrivalTime('2016-01-05T17:30');

        $flightInfo = FlightInfo::create('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $boardingPass = BoardingPass::create('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'https://www.example.com/barcode.jpg', 'https://www.example.com/en/PLAT.png', $flightInfo);
        self::assertJsonStringEqualsJsonString('{"passenger_name":"Smith Nicolas","pnr_number":"CG4X7U","logo_image_url":"https://www.example.com/en/logo.png","barcode_image_url":"https://www.example.com/barcode.jpg","above_bar_code_image_url":"https://www.example.com/en/PLAT.png","flight_info":{"flight_number":"KL0642","departure_airport":{"airport_code":"JFK","city":"New York","terminal":"T1","gate":"D57"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam"},"flight_schedule":{"departure_time":"2016-01-02T19:05","arrival_time":"2016-01-05T17:30"}}}', json_encode($boardingPass));
    }

    public function testTravelClass(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('travelClass must be either "economy, business, first_class".');
        $this->boardingPass->setTravelClass('second_class');
    }

    public function testAddToManyAuxiliaryFields(): void
    {
        $this->expectException(MessengerException::class);
        $this->boardingPass
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addAuxiliaryFields('Boarding', '18:30')
            ->addAuxiliaryFields('Gate', 'D57')
            ->addAuxiliaryFields('Seat', '74J')
            ->addAuxiliaryFields('Sec.Nr.', '003');
    }

    public function testAddToManySecondaryFields(): void
    {
        $this->expectException(MessengerException::class);
        $this->boardingPass
            ->addSecondaryFields('Terminal', 'T1')
            ->addSecondaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74J')
            ->addSecondaryFields('Sec.Nr.', '003');
    }

    public function tearDown(): void
    {
        unset($this->boardingPass);
    }
}
