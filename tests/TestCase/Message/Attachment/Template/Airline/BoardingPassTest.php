<?php
namespace Kerox\Messenger\Test\TestCase\Message\Attachment\Template\Airline;

use InvalidArgumentException;
use Kerox\Messenger\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Message\Attachment\Template\Airline\BoardingPass;
use Kerox\Messenger\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class BoardingPassTest extends AbstractTestCase
{

    /**
     * @var BoardingPass
     */
    protected $boardingPass;

    public function setUp()
    {
        $departureAirport = (new Airport('JFK', 'New York'))->setTerminal('T1')->setGate('D57');
        $arrivalAirport = new Airport('AMS', 'Amsterdam');
        $flightSchedule = (new FlightSchedule('2016-01-02T19:05'))->setArrivalTime('2016-01-05T17:30');

        $flightInfo = new FlightInfo('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $this->boardingPass = new BoardingPass('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo);
    }

    public function testTravelClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->boardingPass->setTravelClass('second_class');

    }

    public function testAddToManyAuxiliaryFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->boardingPass
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addAuxiliaryFields('Boarding', '18:30')
            ->addAuxiliaryFields('Gate', 'D57')
            ->addAuxiliaryFields('Seat', '74J')
            ->addAuxiliaryFields('Sec.Nr.', '003');
    }

    public function testAddToManySecondaryFields()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->boardingPass
            ->addSecondaryFields('Terminal', 'T1')
            ->addSecondaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74J')
            ->addSecondaryFields('Sec.Nr.', '003');
    }

    public function tearDown()
    {
        unset($this->boardingPass);
    }
}