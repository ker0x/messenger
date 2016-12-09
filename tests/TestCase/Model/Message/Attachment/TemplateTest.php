<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment;

use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\TravelClassInterface;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineBoardingPass;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineCheckIn;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineItinerary;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineUpdate;
use Kerox\Messenger\Model\Message\Attachment\Template\Button;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Generic;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Liste;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TemplateTest extends AbstractTestCase
{
    public function testTemplateAirlineBoardingPass()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_boardingpass.json');

        $departureAirport = (new Airport('JFK', 'New York'))->setTerminal('T1')->setGate('D57');
        $arrivalAirport = new Airport('AMS', 'Amsterdam');
        $flightSchedule = (new FlightSchedule('2016-01-02T19:05'))->setArrivalTime('2016-01-05T17:30');

        $flightInfo = new FlightInfo('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $boardingPass1 = new BoardingPass('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo);
        $boardingPass1
            ->setTravelClass('business')
            ->setSeat('74J')
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74J')
            ->addSecondaryFields('Sec.Nr.', '003')
            ->setHeaderImageUrl('https://www.example.com/en/fb/header.png');


        $boardingPass2 = new BoardingPass('Jones Farbound', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1JONES FARBOUND  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo);
        $boardingPass2
            ->setTravelClass('business')
            ->setSeat('74K')
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74K')
            ->addSecondaryFields('Sec.Nr.', '004')
            ->setHeaderImageUrl('https://www.example.com/en/fb/header.png');

        $boardingPass = [
            $boardingPass1,
            $boardingPass2,
        ];

        $airlineBoardingPass = new AirlineBoardingPass('You are checked in.', 'en_US', $boardingPass);
        $airlineBoardingPass
            ->setThemeColor('#FF0000');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineBoardingPass));
    }

    public function testTemplateAirlineCheckIn()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_checkin.json');

        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('SEA', 'Seattle'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2016-01-05T15:45'))->setArrivalTime('2016-01-05T17:30')->setBoardingTime('2016-01-05T15:05');

        $flightInto = [
            new FlightInfo('f001', $departureAirport, $arrivalAirport, $flightSchedule)
        ];

        $airlineCheckIn = new AirlineCheckIn('Check-in is available now.', 'en_US', 'ABCDEF', $flightInto, 'https://www.airline.com/check-in');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineCheckIn));
    }

    public function testTemplateAirlineItinerary()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_itinerary.json');

        $departureAirport1 = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $departureAirport2 = (new Airport('SLC', 'Salt Lake City'))->setTerminal('T1')->setGate('G33');

        $arrivalAirport1 = (new Airport('SLC', 'Salt Lake City'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport2 = (new Airport('AMS', 'Amsterdam'))->setTerminal('T1')->setGate('G33');

        $flightSchedule1 = (new FlightSchedule('2016-01-02T19:45'))->setArrivalTime('2016-01-02T21:20');
        $flightSchedule2 = (new FlightSchedule('2016-01-02T22:45'))->setArrivalTime('2016-01-03T17:20');


        $passengerInfo = [
            (new PassengerInfo('p001', 'Farbound Smith Jr'))->setTicketNumber('0741234567890'),
            (new PassengerInfo('p002', 'Nick Jones'))->setTicketNumber('0741234567891'),
        ];

        $flightInfo = [
            (new ExtendedFlightInfo('c001', 's001', 'KL9123', $departureAirport1, $arrivalAirport1, $flightSchedule1, TravelClassInterface::BUSINESS))->setAircraftType('Boeing 737'),
            (new ExtendedFlightInfo('c002', 's002', 'KL321', $departureAirport2, $arrivalAirport2, $flightSchedule2, TravelClassInterface::BUSINESS))->setAircraftType('Boeing 747-200'),
        ];

        $passengerSegmentInfo = [
            new PassengerSegmentInfo('s001', 'p001', '12A', 'Business'),
            new PassengerSegmentInfo('s001', 'p002', '12B', 'Business'),
            (new PassengerSegmentInfo('s002', 'p001', '73A', 'World Business'))->addProductInfo('Lounge', 'Complimentary lounge access')->addProductInfo('Baggage', '1 extra bag 50lbs'),
            (new PassengerSegmentInfo('s002', 'p002', '73B', 'World Business'))->addProductInfo('Lounge', 'Complimentary lounge access')->addProductInfo('Baggage', '1 extra bag 50lbs'),
        ];

        $airlineItinerary = new AirlineItinerary('Here\'s your flight itinerary.', 'en_US', 'ABCDEF', $passengerInfo, $flightInfo, $passengerSegmentInfo, '14003', 'USD');
        $airlineItinerary
            ->addPriceInfo('Fuel surcharge', '1597', 'USD')
            ->setBasePrice('12206')
            ->setTax('200');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineItinerary));
    }

    public function testTemplateAirlineUpdate()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_update.json');

        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('AMS', 'Amsterdam'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2015-12-26T11:30'))->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = new FlightInfo('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineUpdate = new AirlineUpdate(AirlineUpdate::UPDATE_TYPE_DELAY, 'en_US', 'CF23G2', $updateFlightInfo);
        $airlineUpdate
            ->setIntroMessage('Your flight is delayed');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineUpdate));
    }

    public function testTemplateButton()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/button.json');

        $button = new Button('What do you want to do next?', [
            new WebUrl('Show Website', 'https://petersapparel.parseapp.com'),
            new Postback('Start Chatting', 'USER_DEFINED_PAYLOAD'),
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));
    }

    public function testTemplateGeneric()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/generic.json');

        $element = (new GenericElement('Welcome to Peter\'s Hats'))
            ->setItemUrl('https://petersfancybrownhats.com')
            ->setImageUrl('https://petersfancybrownhats.com/company_image.png')
            ->setSubtitle('We\'ve got the right hat for everyone.')
            ->setButtons([
                new WebUrl('View Website', 'https://petersfancybrownhats.com'),
                new Postback('Start Chatting', 'DEVELOPER_DEFINED_PAYLOAD'),
            ]);

        $generic = new Generic([$element]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($generic));
    }

    public function testTemplateListe()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/liste.json');

        $element1 = (new ListeElement('Classic White T-Shirt'))
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=100'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=100'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $element2 = (new ListeElement('Classic Blue T-Shirt'))
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/blue-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=101'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=101'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $element3 = (new ListeElement('Classic Black T-Shirt'))
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/black-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=102'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=102'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $element4 = (new ListeElement('Classic Gray T-Shirt'))
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/gray-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=103'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=103'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $liste = new Liste([$element1, $element2, $element3, $element4]);
        $liste
            ->setTopElementStyle(Liste::TOP_ELEMENT_STYLE_COMPACT)
            ->setButtons([
                new Postback('View More', 'payload')
            ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($liste));
    }

    public function testTemplateReceipt()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/receipt.json');

        $elements = [
            (new ReceiptElement('Classic White T-Shirt', 50))->setSubtitle('100% Soft and Luxurious Cotton')->setQuantity(2)->setCurrency('USD')->setImageUrl('http://petersapparel.parseapp.com/img/whiteshirt.png'),
            (new ReceiptElement('Classic Gray T-Shirt', 25))->setSubtitle('100% Soft and Luxurious Cotton')->setQuantity(1)->setCurrency('USD')->setImageUrl('http://petersapparel.parseapp.com/img/grayshirt.png'),
        ];
        $summary = (new Summary(56.14))->setSubtotal(75.00)->setShippingCost(4.95)->setTotalTax(6.19);

        $receipt = new Receipt('Stephane Crozatier', '12345678902', 'USD', 'Visa 2345', $elements, $summary);
        $receipt
            ->setOrderUrl('http://petersapparel.parseapp.com/order?order_id=123456')
            ->setTimestamp('1428444852')
            ->setAddress((new Address('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US'))->setAdditionalStreet('Apt 2'))
            ->setAdjustments([
                (new Adjustment())->setName('New Customer Discount')->setAmount(20),
                (new Adjustment())->setName('$10 Off Coupon')->setAmount(10),
            ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($receipt));
    }
}