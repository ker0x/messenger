<?php
namespace Kerox\Messenger\Test\TestCase\Callback;

use Kerox\Messenger\Event\AccountLinkingEvent;
use Kerox\Messenger\Event\AppRolesEvent;
use Kerox\Messenger\Event\CheckoutUpdateEvent;
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
use Kerox\Messenger\Model\Callback\AppRoles;
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

class EventTest extends AbstractTestCase
{

    public function testMessageEvent()
    {
        $mockedMessage = $this->createMock(Message::class);
        $event = new MessageEvent('sender_id', 'recipient_id', 123456, $mockedMessage);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedMessage, $event->getMessage());
        $this->assertEquals('message', $event->getName());
        $this->assertFalse($event->isQuickReply());
    }

    public function testMessageEchoEvent()
    {
        $mockedMessageEcho = $this->createMock(MessageEcho::class);
        $event = new MessageEchoEvent('sender_id', 'recipient_id', 123456, $mockedMessageEcho);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedMessageEcho, $event->getMessageEcho());
        $this->assertEquals('message_echo', $event->getName());
    }

    public function testReadEvent()
    {
        $mockedRead = $this->createMock(Read::class);
        $event = new ReadEvent('sender_id', 'recipient_id', 123456, $mockedRead);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedRead, $event->getRead());
        $this->assertEquals('read', $event->getName());
    }

    public function testDeliveryEvent()
    {
        $mockedDelivery = $this->createMock(Delivery::class);
        $event = new DeliveryEvent('sender_id', 'recipient_id', $mockedDelivery);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals($mockedDelivery, $event->getDelivery());
        $this->assertEquals('delivery', $event->getName());
    }

    public function testPostbackEvent()
    {
        $mockedPostback = $this->createMock(Postback::class);
        $event = new PostbackEvent('sender_id', 'recipient_id', 123456, $mockedPostback);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPostback, $event->getPostback());
        $this->assertEquals('postback', $event->getName());
    }

    public function testOptinEvent()
    {
        $mockedOptin = $this->createMock(Optin::class);
        $event = new OptinEvent('sender_id', 'recipient_id', 123456, $mockedOptin);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedOptin, $event->getOptin());
        $this->assertEquals('optin', $event->getName());
    }

    public function testAccountLinkingEvent()
    {
        $mockedAccountLinking = $this->createMock(AccountLinking::class);
        $event = new AccountLinkingEvent('sender_id', 'recipient_id', 123456, $mockedAccountLinking);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedAccountLinking, $event->getAccountLinking());
        $this->assertEquals('account_linking', $event->getName());
    }

    public function testPaymentEvent()
    {
        $mockedPayment = $this->createMock(Payment::class);
        $event = new PaymentEvent('sender_id', 'recipient_id', 123456, $mockedPayment);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPayment, $event->getPayment());
        $this->assertEquals('payment', $event->getName());
    }

    public function testCheckoutUpdate()
    {
        $mockedCheckoutUpdate = $this->createMock(CheckoutUpdate::class);
        $event = new CheckoutUpdateEvent('sender_id', 'recipient_id', 123456, $mockedCheckoutUpdate);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedCheckoutUpdate, $event->getCheckoutUpdate());
        $this->assertEquals('checkout_update', $event->getName());
    }

    public function testPreCheckout()
    {
        $mockedPreCheckout = $this->createMock(PreCheckout::class);
        $event = new PreCheckoutEvent('sender_id', 'recipient_id', 123456, $mockedPreCheckout);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPreCheckout, $event->getPreCheckout());
        $this->assertEquals('pre_checkout', $event->getName());
    }

    public function testPassThreadControl()
    {
        $mockedPassThreadControl = $this->createMock(PassThreadControl::class);
        $event = new PassThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedPassThreadControl);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPassThreadControl, $event->getPassThreadControl());
        $this->assertEquals('pass_thread_control', $event->getName());
    }

    public function testTakeThreadControl()
    {
        $mockedTakeThreadControl = $this->createMock(TakeThreadControl::class);
        $event = new TakeThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedTakeThreadControl);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedTakeThreadControl, $event->getTakeThreadControl());
        $this->assertEquals('take_thread_control', $event->getName());
    }

    public function testPolicyEnforcement()
    {
        $mockedPolicyEnforcement = $this->createMock(PolicyEnforcement::class);
        $event = new PolicyEnforcementEvent('sender_id', 'recipient_id', 123456, $mockedPolicyEnforcement);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPolicyEnforcement, $event->getPolicyEnforcement());
        $this->assertEquals('policy_enforcement', $event->getName());
    }

    public function testAppRoles()
    {
        $mockedAppRoles = $this->createMock(AppRoles::class);
        $event = new AppRolesEvent('sender_id', 'recipient_id', 123456, $mockedAppRoles);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedAppRoles, $event->getAppRoles());
        $this->assertEquals('app_roles', $event->getName());
    }

    public function testRawEvent()
    {
        $event = new RawEvent('sender_id', 'recipient_id', ['payload' => 'PAYLOAD']);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(['payload' => 'PAYLOAD'], $event->getRaw());
        $this->assertEquals('raw', $event->getName());
    }
}