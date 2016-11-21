<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template;


use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AirlineTest extends AbstractTestCase
{

    public function testAirlineAirport()
    {
        $airlineAirport = new Airport('SFO', 'San Francisco');
        $airlineAirport
            ->setTerminal('T4')
            ->setGate('G8');

        $this->assertJsonStringEqualsJsonString('{"airport_code": "SFO","city": "San Francisco","terminal": "T4","gate": "G8"}', json_encode($airlineAirport));
    }

    public function testAirlineBoardingPass()
    {
        $departureAirport = (new Airport('JFK', 'New York'))->setTerminal('T1')->setGate('D57');
        $arrivalAirport = new Airport('AMS', 'Amsterdam');
        $flightSchedule = (new FlightSchedule('2016-01-02T19:05'))->setArrivalTime('2016-01-05T17:30');

        $flightInfo = new FlightInfo('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineBoardingPass = new BoardingPass('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo);
        $airlineBoardingPass
            ->setTravelClass('business')
            ->setSeat('74J')
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74J')
            ->addSecondaryFields('Sec.Nr.', '003')
            ->setHeaderImageUrl('https://www.example.com/en/fb/header.png')
            ->setHeaderTextField('Boarding Pass');

        $this->assertJsonStringEqualsJsonString('{"passenger_name":"Smith Nicolas","pnr_number":"CG4X7U","travel_class":"business","seat":"74J","auxiliary_fields":[{"label":"Terminal","value":"T1"},{"label":"Departure","value":"30OCT 19:05"}],"secondary_fields":[{"label":"Boarding","value":"18:30"},{"label":"Gate","value":"D57"},{"label":"Seat","value":"74J"},{"label":"Sec.Nr.","value":"003"}],"logo_image_url":"https://www.example.com/en/logo.png","header_image_url":"https://www.example.com/en/fb/header.png","header_text_field":"Boarding Pass","qr_code":"M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh","above_bar_code_image_url":"https://www.example.com/en/PLAT.png","flight_info":{"flight_number":"KL0642","departure_airport":{"airport_code":"JFK","city":"New York","terminal":"T1","gate":"D57"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam"},"flight_schedule":{"departure_time":"2016-01-02T19:05","arrival_time":"2016-01-05T17:30"}}}', json_encode($airlineBoardingPass));
    }

    public function testAirlineExtendedFlightInfo()
    {
        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('SLC', 'Salt Lake City'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2016-01-02T19:45'))->setArrivalTime('2016-01-02T21:20');

        $airlineExtendedFlightInfo = new ExtendedFlightInfo('c001', 's001', 'KL9123', $departureAirport, $arrivalAirport, $flightSchedule, 'business');
        $airlineExtendedFlightInfo
            ->setAircraftType('Boeing 737');

        $this->assertJsonStringEqualsJsonString('{"connection_id":"c001","segment_id":"s001","flight_number":"KL9123","aircraft_type":"Boeing 737","departure_airport":{"airport_code":"SFO","city":"San Francisco","terminal":"T4","gate":"G8"},"arrival_airport":{"airport_code":"SLC","city":"Salt Lake City","terminal":"T4","gate":"G8"},"flight_schedule":{"departure_time":"2016-01-02T19:45","arrival_time":"2016-01-02T21:20"},"travel_class":"business"}', json_encode($airlineExtendedFlightInfo));
    }

    public function testAirlineFlightInfo()
    {
        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('AMS', 'Amsterdam'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2015-12-26T11:30'))->setBoardingTime('2015-12-26T10:30')->setArrivalTime('2015-12-27T07:30');

        $airlineFlightInfo = new FlightInfo('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $this->assertJsonStringEqualsJsonString('{"flight_number":"KL123","departure_airport":{"airport_code":"SFO","city":"San Francisco","terminal":"T4","gate":"G8"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam","terminal":"T4","gate":"G8"},"flight_schedule":{"boarding_time":"2015-12-26T10:30","departure_time":"2015-12-26T11:30","arrival_time":"2015-12-27T07:30"}}', json_encode($airlineFlightInfo));
    }

    public function testAirlineFlightShedule()
    {
        $airlineFlightSchedule = new FlightSchedule('2015-12-26T11:30');
        $airlineFlightSchedule
            ->setBoardingTime('2015-12-26T10:30')
            ->setArrivalTime('2015-12-27T07:30');

        $this->assertJsonStringEqualsJsonString('{"boarding_time": "2015-12-26T10:30","departure_time": "2015-12-26T11:30","arrival_time": "2015-12-27T07:30"}', json_encode($airlineFlightSchedule));
    }

    public function testAirlinePassengerInfo()
    {
        $airlinePassengerInfo = new PassengerInfo('p001', 'Farbound Smith Jr');
        $airlinePassengerInfo
            ->setTicketNumber('0741234567890');

        $this->assertJsonStringEqualsJsonString('{"name":"Farbound Smith Jr","ticket_number":"0741234567890","passenger_id":"p001"}', json_encode($airlinePassengerInfo));
    }

    public function testAirlinePassengerSegmentInfo()
    {
        $airlinePassengerSegmentInfo = new PassengerSegmentInfo('s002', 'p001', '73A', 'World Business');
        $airlinePassengerSegmentInfo
            ->addProductInfo('Lounge', 'Complimentary lounge access')
            ->addProductInfo('Baggage', '1 extra bag 50lbs');

        $this->assertJsonStringEqualsJsonString('{"segment_id":"s002","passenger_id":"p001","seat":"73A","seat_type":"World Business","product_info":[{"title":"Lounge","value":"Complimentary lounge access"},{"title":"Baggage","value":"1 extra bag 50lbs"}]}', json_encode($airlinePassengerSegmentInfo));
    }
}