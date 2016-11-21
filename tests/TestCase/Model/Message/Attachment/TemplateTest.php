<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment;

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
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Address;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TemplateTest extends AbstractTestCase
{
    public function testTemplateAirlineBoardingPass()
    {
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

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"airline_boardingpass","intro_message":"You are checked in.","locale":"en_US","theme_color":"#FF0000","boarding_pass":[{"passenger_name":"Smith Nicolas","pnr_number":"CG4X7U","travel_class":"business","seat":"74J","auxiliary_fields":[{"label":"Terminal","value":"T1"},{"label":"Departure","value":"30OCT 19:05"}],"secondary_fields":[{"label":"Boarding","value":"18:30"},{"label":"Gate","value":"D57"},{"label":"Seat","value":"74J"},{"label":"Sec.Nr.","value":"003"}],"logo_image_url":"https://www.example.com/en/logo.png","header_image_url":"https://www.example.com/en/fb/header.png","qr_code":"M1SMITH NICOLAS  CG4X7U nawouehgawgnapwi3jfa0wfh","above_bar_code_image_url":"https://www.example.com/en/PLAT.png","flight_info":{"flight_number":"KL0642","departure_airport":{"airport_code":"JFK","city":"New York","terminal":"T1","gate":"D57"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam"},"flight_schedule":{"departure_time":"2016-01-02T19:05","arrival_time":"2016-01-05T17:30"}}},{"passenger_name":"Jones Farbound","pnr_number":"CG4X7U","travel_class":"business","seat":"74K","auxiliary_fields":[{"label":"Terminal","value":"T1"},{"label":"Departure","value":"30OCT 19:05"}],"secondary_fields":[{"label":"Boarding","value":"18:30"},{"label":"Gate","value":"D57"},{"label":"Seat","value":"74K"},{"label":"Sec.Nr.","value":"004"}],"logo_image_url":"https://www.example.com/en/logo.png","header_image_url":"https://www.example.com/en/fb/header.png","qr_code":"M1JONES FARBOUND  CG4X7U nawouehgawgnapwi3jfa0wfh","above_bar_code_image_url":"https://www.example.com/en/PLAT.png","flight_info":{"flight_number":"KL0642","departure_airport":{"airport_code":"JFK","city":"New York","terminal":"T1","gate":"D57"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam"},"flight_schedule":{"departure_time":"2016-01-02T19:05","arrival_time":"2016-01-05T17:30"}}}]}}', json_encode($airlineBoardingPass));
    }

    public function testTemplateAirlineCheckIn()
    {
        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('SEA', 'Seattle'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2016-01-05T15:45'))->setArrivalTime('2016-01-05T17:30')->setBoardingTime('2016-01-05T15:05');

        $flightInto = [
            new FlightInfo('f001', $departureAirport, $arrivalAirport, $flightSchedule)
        ];

        $airlineCheckIn = new AirlineCheckIn('Check-in is available now.', 'en_US', 'ABCDEF', $flightInto, 'https://www.airline.com/check-in');

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"airline_checkin","intro_message":"Check-in is available now.","locale":"en_US","pnr_number":"ABCDEF","flight_info":[{"flight_number":"f001","departure_airport":{"airport_code":"SFO","city":"San Francisco","terminal":"T4","gate":"G8"},"arrival_airport":{"airport_code":"SEA","city":"Seattle","terminal":"T4","gate":"G8"},"flight_schedule":{"boarding_time":"2016-01-05T15:05","departure_time":"2016-01-05T15:45","arrival_time":"2016-01-05T17:30"}}],"checkin_url":"https://www.airline.com/check-in"}}', json_encode($airlineCheckIn));
    }

    public function testTemplateAirlineItinerary()
    {
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

        $airlineItinerary = new AirlineItinerary('Here\'s your flight itinerary.', 'en_US', 'ABCDEF', $passengerInfo, $flightInfo, $passengerSegmentInfo, 14003, 'USD');
        $airlineItinerary
            ->addPriceInfo('Fuel surcharge', '1597', 'USD')
            ->setBasePrice(12206)
            ->setTax(200);

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"airline_itinerary","intro_message":"Here\'s your flight itinerary.","locale":"en_US","pnr_number":"ABCDEF","passenger_info":[{"name":"Farbound Smith Jr","ticket_number":"0741234567890","passenger_id":"p001"},{"name":"Nick Jones","ticket_number":"0741234567891","passenger_id":"p002"}],"flight_info":[{"connection_id":"c001","segment_id":"s001","flight_number":"KL9123","aircraft_type":"Boeing 737","departure_airport":{"airport_code":"SFO","city":"San Francisco","terminal":"T4","gate":"G8"},"arrival_airport":{"airport_code":"SLC","city":"Salt Lake City","terminal":"T4","gate":"G8"},"flight_schedule":{"departure_time":"2016-01-02T19:45","arrival_time":"2016-01-02T21:20"},"travel_class":"business"},{"connection_id":"c002","segment_id":"s002","flight_number":"KL321","aircraft_type":"Boeing 747-200","travel_class":"business","departure_airport":{"airport_code":"SLC","city":"Salt Lake City","terminal":"T1","gate":"G33"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam","terminal":"T1","gate":"G33"},"flight_schedule":{"departure_time":"2016-01-02T22:45","arrival_time":"2016-01-03T17:20"}}],"passenger_segment_info":[{"segment_id":"s001","passenger_id":"p001","seat":"12A","seat_type":"Business"},{"segment_id":"s001","passenger_id":"p002","seat":"12B","seat_type":"Business"},{"segment_id":"s002","passenger_id":"p001","seat":"73A","seat_type":"World Business","product_info":[{"title":"Lounge","value":"Complimentary lounge access"},{"title":"Baggage","value":"1 extra bag 50lbs"}]},{"segment_id":"s002","passenger_id":"p002","seat":"73B","seat_type":"World Business","product_info":[{"title":"Lounge","value":"Complimentary lounge access"},{"title":"Baggage","value":"1 extra bag 50lbs"}]}],"price_info":[{"title":"Fuel surcharge","amount":"1597","currency":"USD"}],"base_price":"12206","tax":"200","total_price":"14003","currency":"USD"}}', json_encode($airlineItinerary));
    }

    public function testTemplateAirlineUpdate()
    {
        $departureAirport = (new Airport('SFO', 'San Francisco'))->setTerminal('T4')->setGate('G8');
        $arrivalAirport = (new Airport('AMS', 'Amsterdam'))->setTerminal('T4')->setGate('G8');
        $flightSchedule = (new FlightSchedule('2015-12-26T11:30'))->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = new FlightInfo('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        $airlineUpdate = new AirlineUpdate(AirlineUpdate::UPDATE_TYPE_DELAY, 'en_US', 'CF23G2', $updateFlightInfo);
        $airlineUpdate
            ->setIntroMessage('Your flight is delayed');

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"airline_update","intro_message":"Your flight is delayed","update_type":"delay","locale":"en_US","pnr_number":"CF23G2","update_flight_info":{"flight_number":"KL123","departure_airport":{"airport_code":"SFO","city":"San Francisco","terminal":"T4","gate":"G8"},"arrival_airport":{"airport_code":"AMS","city":"Amsterdam","terminal":"T4","gate":"G8"},"flight_schedule":{"boarding_time":"2015-12-26T10:30","departure_time":"2015-12-26T11:30","arrival_time":"2015-12-27T07:30"}}}}', json_encode($airlineUpdate));
    }

    public function testTemplateButton()
    {
        $button = new Button('What do you want to do next?', [
            new WebUrl('Show Website', 'https://petersapparel.parseapp.com'),
            new Postback('Start Chatting', 'USER_DEFINED_PAYLOAD'),
        ]);

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"button","text":"What do you want to do next?","buttons":[{"type":"web_url","url":"https://petersapparel.parseapp.com","title":"Show Website"},{"type":"postback","title":"Start Chatting","payload":"USER_DEFINED_PAYLOAD"}]}}', json_encode($button));
    }

    public function testTemplateGeneric()
    {
        $element = (new GenericElement('Welcome to Peter\'s Hats'))
            ->setItemUrl('https://petersfancybrownhats.com')
            ->setImageUrl('https://petersfancybrownhats.com/company_image.png')
            ->setSubtitle('We\'ve got the right hat for everyone.')
            ->setButtons([
                new WebUrl('View Website', 'https://petersfancybrownhats.com'),
                new Postback('Start Chatting', 'DEVELOPER_DEFINED_PAYLOAD'),
            ]);

        $generic = new Generic([$element]);

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"generic","elements":[{"title":"Welcome to Peter\'s Hats","item_url":"https://petersfancybrownhats.com","image_url":"https://petersfancybrownhats.com/company_image.png","subtitle":"We\'ve got the right hat for everyone.","buttons":[{"type":"web_url","url":"https://petersfancybrownhats.com","title":"View Website"},{"type":"postback","title":"Start Chatting","payload":"DEVELOPER_DEFINED_PAYLOAD"}]}]}}', json_encode($generic));
    }

    public function testTemplateListe()
    {
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

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"list","top_element_style":"compact","elements":[{"title":"Classic White T-Shirt","image_url":"https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png","subtitle":"100% Cotton, 200% Comfortable","default_action":{"type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/view?item=100","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"},"buttons":[{"title":"Buy","type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/shop?item=100","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"}]},{"title":"Classic Blue T-Shirt","image_url":"https://peterssendreceiveapp.ngrok.io/img/blue-t-shirt.png","subtitle":"100% Cotton, 200% Comfortable","default_action":{"type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/view?item=101","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"},"buttons":[{"title":"Buy","type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/shop?item=101","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"}]},{"title":"Classic Black T-Shirt","image_url":"https://peterssendreceiveapp.ngrok.io/img/black-t-shirt.png","subtitle":"100% Cotton, 200% Comfortable","default_action":{"type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/view?item=102","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"},"buttons":[{"title":"Buy","type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/shop?item=102","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"}]},{"title":"Classic Gray T-Shirt","image_url":"https://peterssendreceiveapp.ngrok.io/img/gray-t-shirt.png","subtitle":"100% Cotton, 200% Comfortable","default_action":{"type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/view?item=103","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"},"buttons":[{"title":"Buy","type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/shop?item=103","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"}]}],"buttons":[{"title":"View More","type":"postback","payload":"payload"}]}}', json_encode($liste));
    }

    public function testTemplateReceipt()
    {
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

        $this->assertJsonStringEqualsJsonString('{"type":"template","payload":{"template_type":"receipt","recipient_name":"Stephane Crozatier","order_number":"12345678902","currency":"USD","payment_method":"Visa 2345","order_url":"http://petersapparel.parseapp.com/order?order_id=123456","timestamp":"1428444852","elements":[{"title":"Classic White T-Shirt","subtitle":"100% Soft and Luxurious Cotton","quantity":2,"price":50,"currency":"USD","image_url":"http://petersapparel.parseapp.com/img/whiteshirt.png"},{"title":"Classic Gray T-Shirt","subtitle":"100% Soft and Luxurious Cotton","quantity":1,"price":25,"currency":"USD","image_url":"http://petersapparel.parseapp.com/img/grayshirt.png"}],"address":{"street_1":"1 Hacker Way","street_2":"Apt 2","city":"Menlo Park","postal_code":"94025","state":"CA","country":"US"},"summary":{"subtotal":75.00,"shipping_cost":4.95,"total_tax":6.19,"total_cost":56.14},"adjustments":[{"name":"New Customer Discount","amount":20},{"name":"$10 Off Coupon","amount":10}]}}', json_encode($receipt));
    }
}