<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment;

use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo;
use Kerox\Messenger\Model\Message\Attachment\Template\Airline\TravelClassInterface;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineBoardingPassTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineCheckInTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineItineraryTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ListElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\MediaElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\ListTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\MediaTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\OpenGraphTemplate;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Model\Message\Attachment\Template\ReceiptTemplate;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TemplateTest extends AbstractTestCase
{
    public function testTemplateAirlineBoardingPass(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_boardingpass.json');

        $departureAirport = Airport::create('JFK', 'New York')->setTerminal('T1')->setGate('D57');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam');
        $flightSchedule = FlightSchedule::create('2016-01-02T19:05')->setArrivalTime('2016-01-05T17:30');

        $flightInfo = FlightInfo::create('KL0642', $departureAirport, $arrivalAirport, $flightSchedule);

        $boardingPass1 = BoardingPass::create('Smith Nicolas', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo)
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

        $boardingPass2 = BoardingPass::create('Jones Farbound', 'CG4X7U', 'https://www.example.com/en/logo.png', 'M1JONES FARBOUND  CG4X7U nawouehgawgnapwi3jfa0wfh', 'https://www.example.com/en/PLAT.png', $flightInfo)
            ->setTravelClass('business')
            ->setSeat('74K')
            ->addAuxiliaryFields('Terminal', 'T1')
            ->addAuxiliaryFields('Departure', '30OCT 19:05')
            ->addSecondaryFields('Boarding', '18:30')
            ->addSecondaryFields('Gate', 'D57')
            ->addSecondaryFields('Seat', '74K')
            ->addSecondaryFields('Sec.Nr.', '004')
            ->setHeaderImageUrl('https://www.example.com/en/fb/header.png')
            ->setHeaderTextField('Boarding Pass');

        $boardingPass = [
            $boardingPass1,
            $boardingPass2,
        ];

        $airlineBoardingPass = AirlineBoardingPassTemplate::create('You are checked in.', 'en_US', $boardingPass)
            ->setThemeColor('#FF0000');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineBoardingPass));
    }

    public function testTemplateAirlineCheckIn(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_checkin.json');

        $departureAirport = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $arrivalAirport = Airport::create('SEA', 'Seattle')->setTerminal('T4')->setGate('G8');
        $flightSchedule = FlightSchedule::create('2016-01-05T15:45')->setArrivalTime('2016-01-05T17:30')->setBoardingTime('2016-01-05T15:05');

        $flightInto = [
            FlightInfo::create('f001', $departureAirport, $arrivalAirport, $flightSchedule),
        ];

        $airlineCheckIn = AirlineCheckInTemplate::create('Check-in is available now.', 'en_US', 'ABCDEF', $flightInto, 'https://www.airline.com/check-in');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineCheckIn));
    }

    public function testTemplateAirlineItinerary(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_itinerary.json');

        $departureAirport1 = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $departureAirport2 = Airport::create('SLC', 'Salt Lake City')->setTerminal('T1')->setGate('G33');

        $arrivalAirport1 = Airport::create('SLC', 'Salt Lake City')->setTerminal('T4')->setGate('G8');
        $arrivalAirport2 = Airport::create('AMS', 'Amsterdam')->setTerminal('T1')->setGate('G33');

        $flightSchedule1 = FlightSchedule::create('2016-01-02T19:45')->setArrivalTime('2016-01-02T21:20');
        $flightSchedule2 = FlightSchedule::create('2016-01-02T22:45')->setArrivalTime('2016-01-03T17:20');

        $passengerInfo = [
            PassengerInfo::create('p001', 'Farbound Smith Jr')->setTicketNumber('0741234567890'),
            PassengerInfo::create('p002', 'Nick Jones')->setTicketNumber('0741234567891'),
        ];

        $flightInfo = [
            ExtendedFlightInfo::create('c001', 's001', 'KL9123', $departureAirport1, $arrivalAirport1, $flightSchedule1, TravelClassInterface::BUSINESS)->setAircraftType('Boeing 737'),
            ExtendedFlightInfo::create('c002', 's002', 'KL321', $departureAirport2, $arrivalAirport2, $flightSchedule2, TravelClassInterface::BUSINESS)->setAircraftType('Boeing 747-200'),
        ];

        $passengerSegmentInfo = [
            PassengerSegmentInfo::create('s001', 'p001', '12A', 'Business'),
            PassengerSegmentInfo::create('s001', 'p002', '12B', 'Business'),
            PassengerSegmentInfo::create('s002', 'p001', '73A', 'World Business')
                ->addProductInfo('Lounge', 'Complimentary lounge access')
                ->addProductInfo('Baggage', '1 extra bag 50lbs'),
            PassengerSegmentInfo::create('s002', 'p002', '73B', 'World Business')
                ->addProductInfo('Lounge', 'Complimentary lounge access')
                ->addProductInfo('Baggage', '1 extra bag 50lbs'),
        ];

        $airlineItinerary = AirlineItineraryTemplate::create('Here\'s your flight itinerary.', 'en_US', 'ABCDEF', $passengerInfo, $flightInfo, $passengerSegmentInfo, '14003', 'USD')
            ->addPriceInfo('Fuel surcharge', '1597', 'USD')
            ->setBasePrice('12206')
            ->setTax('200');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineItinerary));
    }

    public function testTemplateAirlineUpdate(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/airline_update.json');

        $departureAirport = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam')->setTerminal('T4')->setGate('G8');
        $flightSchedule = FlightSchedule::create('2015-12-26T11:30')->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = FlightInfo::create('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineUpdate = AirlineUpdateTemplate::create(AirlineUpdateTemplate::UPDATE_TYPE_DELAY, 'en_US', 'CF23G2', $updateFlightInfo)
            ->setIntroMessage('Your flight is delayed');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($airlineUpdate));
    }

    public function testTemplateButton(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/button.json');

        $button = ButtonTemplate::create('What do you want to do next?', [
            WebUrl::create('Show Website', 'https://petersapparel.parseapp.com'),
            Postback::create('Start Chatting', 'USER_DEFINED_PAYLOAD'),
        ], true);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($button));
    }

    public function testTemplateGeneric(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/generic.json');

        $element = GenericElement::create('Welcome to Peter\'s Hats')
            ->setImageUrl('https://petersfancybrownhats.com/company_image.png')
            ->setSubtitle('We\'ve got the right hat for everyone.')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=103')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('View Website', 'https://petersfancybrownhats.com'),
                Postback::create('Start Chatting', 'DEVELOPER_DEFINED_PAYLOAD'),
            ]);

        $generic = GenericTemplate::create([$element]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($generic));
    }

    public function testTemplateList(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/list.json');

        $element1 = ListElement::create('Classic White T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=100')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=100')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        $element2 = ListElement::create('Classic Blue T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/blue-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=101')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=101')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        $element3 = ListElement::create('Classic Black T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/black-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=102')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=102')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        $element4 = ListElement::create('Classic Gray T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/gray-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=103')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=103')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        $liste = ListTemplate::create([$element1, $element2, $element3, $element4])
            ->setTopElementStyle(ListTemplate::TOP_ELEMENT_STYLE_COMPACT)
            ->setButtons([
                Postback::create('View More', 'payload'),
            ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($liste));
    }

    public function testTemplateReceipt(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/receipt.json');

        $elements = [
            ReceiptElement::create('Classic White T-Shirt', 50)
                ->setSubtitle('100% Soft and Luxurious Cotton')
                ->setQuantity(2)
                ->setCurrency('USD')
                ->setImageUrl('http://petersapparel.parseapp.com/img/whiteshirt.png'),
            ReceiptElement::create('Classic Gray T-Shirt', 25)
                ->setSubtitle('100% Soft and Luxurious Cotton')
                ->setQuantity(1)
                ->setCurrency('USD')
                ->setImageUrl('http://petersapparel.parseapp.com/img/grayshirt.png'),
        ];
        $summary = Summary::create(56.14)
            ->setSubtotal(75.00)
            ->setShippingCost(4.95)
            ->setTotalTax(6.19);

        $receipt = ReceiptTemplate::create('Stephane Crozatier', '12345678902', 'USD', 'Visa 2345', $elements, $summary)
            ->setOrderUrl('http://petersapparel.parseapp.com/order?order_id=123456')
            ->setTimestamp('1428444852')
            ->setAddress(Address::create('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US')->setAdditionalStreet('Apt 2'))
            ->setAdjustments([
                Adjustment::create()
                    ->setName('New Customer Discount')
                    ->setAmount(20),
                Adjustment::create()
                    ->setName('$10 Off Coupon')
                    ->setAmount(10),
            ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($receipt));
    }

    public function testTemplateOpenGraph(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/open_graph.json');

        $elements = [
            OpenGraphElement::create('https://open.spotify.com/track/7GhIk7Il098yCjg4BQjzvb')
                ->setButtons([
                    WebUrl::create('Learn More', 'https://en.wikipedia.org/wiki/Rickrolling'),
                ]),
        ];

        $openGraph = OpenGraphTemplate::create($elements);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($openGraph));
    }

    public function testTemplateMedia(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../../Mocks/Message/Template/media.json');

        $elements = [
            MediaElement::create('https://www.facebook.com/ker0x/videos/1234567890/', MediaElement::TYPE_VIDEO)
                ->setButtons([
                    WebUrl::create('Learn More', 'https://en.wikipedia.org/wiki/Rickrolling'),
                ]),
        ];

        $media = MediaTemplate::create($elements);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($media));
    }
}
