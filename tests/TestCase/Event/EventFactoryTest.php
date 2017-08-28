<?php
namespace Kerox\Messenger\Test\TestCase\Event;

use Kerox\Messenger\Event\AccountLinkingEvent;
use Kerox\Messenger\Event\CheckoutUpdateEvent;
use Kerox\Messenger\Event\EventFactory;
use Kerox\Messenger\Event\DeliveryEvent;
use Kerox\Messenger\Event\MessageEchoEvent;
use Kerox\Messenger\Event\MessageEvent;
use Kerox\Messenger\Event\OptinEvent;
use Kerox\Messenger\Event\PassThreadControlEvent;
use Kerox\Messenger\Event\PaymentEvent;
use Kerox\Messenger\Event\PolicyEnforcementEvent;
use Kerox\Messenger\Event\PostbackEvent;
use Kerox\Messenger\Event\PreCheckoutEvent;
use Kerox\Messenger\Event\RawEvent;
use Kerox\Messenger\Event\ReadEvent;
use Kerox\Messenger\Event\TakeThreadControlEvent;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\CheckoutUpdate;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\PassThreadControl;
use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\PolicyEnforcement;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\PreCheckout;
use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Model\Callback\TakeThreadControl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class EventFactoryTest extends AbstractTestCase
{

    public function testRawEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/raw.json');
        $array = json_decode($json, true);

        $expectedEvent = new RawEvent('USER_ID', 'PAGE_ID', ['timestamp' => 1458692752478, 'speech' => ['mid' => 'mid.1457764197618:41d102a3e1ae206a38', 'seq' => 73]]);
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testMessageEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/message.json');
        $array = json_decode($json, true);

        $expectedEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, Message::create($array['message']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testMessageEchoEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/message_echo.json');
        $array = json_decode($json, true);

        $expectedEvent = new MessageEchoEvent('USER_ID', 'PAGE_ID', 1457764197627, MessageEcho::create($array['message']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPostbackEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/postback.json');
        $array = json_decode($json, true);

        $expectedEvent = new PostbackEvent('USER_ID', 'PAGE_ID', 1458692752478, Postback::create($array['postback']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testOptinEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/optin.json');
        $array = json_decode($json, true);

        $expectedEvent = new OptinEvent('USER_ID', 'PAGE_ID', 1234567890, Optin::create($array['optin']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testAccountLinkingEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/account_linking.json');
        $array = json_decode($json, true);

        $expectedEvent = new AccountLinkingEvent('USER_ID', 'PAGE_ID', 1234567890, AccountLinking::create($array['account_linking']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testDeliveryEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/delivery.json');
        $array = json_decode($json, true);

        $expectedEvent = new DeliveryEvent('USER_ID', 'PAGE_ID', Delivery::create($array['delivery']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testReadEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/read.json');
        $array = json_decode($json, true);

        $expectedEvent = new ReadEvent('USER_ID', 'PAGE_ID', 1458668856463, Read::create($array['read']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPaymentEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/payment.json');
        $array = json_decode($json, true);

        $expectedEvent = new PaymentEvent('USER_ID', 'PAGE_ID', 1473208792799, Payment::create($array['payment']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testCheckoutUpdateEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/checkout_update.json');
        $array = json_decode($json, true);

        $expectedEvent = new CheckoutUpdateEvent('USER_ID', 'PAGE_ID', 1473204787206, CheckoutUpdate::create($array['checkout_update']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPreCheckoutEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/pre_checkout.json');
        $array = json_decode($json, true);

        $expectedEvent = new PreCheckoutEvent('USER_ID', 'PAGE_ID', 1473208792799, PreCheckout::create($array['pre_checkout']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testTakeThreadControlEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/take_thread_control.json');
        $array = json_decode($json, true);

        $expectedEvent = new TakeThreadControlEvent('USER_ID', 'PAGE_ID', 1458692752478, TakeThreadControl::create($array['take_thread_control']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPassThreadControlEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/pass_thread_control.json');
        $array = json_decode($json, true);

        $expectedEvent = new PassThreadControlEvent('USER_ID', 'PAGE_ID', 1458692752478, PassThreadControl::create($array['pass_thread_control']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPolicyEnforcementEvent()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/policy_enforcement.json');
        $array = json_decode($json, true);

        $expectedEvent = new PolicyEnforcementEvent('', 'PAGE_ID', 1458692752478, PolicyEnforcement::create($array['policy-enforcement']));
        $event = EventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }
}