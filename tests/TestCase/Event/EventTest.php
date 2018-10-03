<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Callback;

use Kerox\Messenger\Event\AccountLinkingEvent;
use Kerox\Messenger\Event\AppRolesEvent;
use Kerox\Messenger\Event\CheckoutUpdateEvent;
use Kerox\Messenger\Event\DeliveryEvent;
use Kerox\Messenger\Event\GamePlayEvent;
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
use Kerox\Messenger\Event\ReferralEvent;
use Kerox\Messenger\Event\RequestThreadControlEvent;
use Kerox\Messenger\Event\TakeThreadControlEvent;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\AppRoles;
use Kerox\Messenger\Model\Callback\CheckoutUpdate;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\GamePlay;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\PassThreadControl;
use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\PolicyEnforcement;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\PreCheckout;
use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Model\Callback\RequestThreadControl;
use Kerox\Messenger\Model\Callback\TakeThreadControl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class EventTest extends AbstractTestCase
{
    public function testMessageEvent(): void
    {
        $mockedMessage = $this->createMock(Message::class);
        $event = new MessageEvent('sender_id', 'recipient_id', 123456, $mockedMessage);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedMessage, $event->getMessage());
        $this->assertSame('message', $event->getName());
        $this->assertFalse($event->isQuickReply());
    }

    public function testMessageEchoEvent(): void
    {
        $mockedMessageEcho = $this->createMock(MessageEcho::class);
        $event = new MessageEchoEvent('sender_id', 'recipient_id', 123456, $mockedMessageEcho);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedMessageEcho, $event->getMessageEcho());
        $this->assertSame('message_echo', $event->getName());
    }

    public function testReadEvent(): void
    {
        $mockedRead = $this->createMock(Read::class);
        $event = new ReadEvent('sender_id', 'recipient_id', 123456, $mockedRead);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedRead, $event->getRead());
        $this->assertSame('read', $event->getName());
    }

    public function testDeliveryEvent(): void
    {
        $mockedDelivery = $this->createMock(Delivery::class);
        $event = new DeliveryEvent('sender_id', 'recipient_id', $mockedDelivery);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame($mockedDelivery, $event->getDelivery());
        $this->assertSame('delivery', $event->getName());
    }

    public function testPostbackEvent(): void
    {
        $mockedPostback = $this->createMock(Postback::class);
        $event = new PostbackEvent('sender_id', 'recipient_id', 123456, $mockedPostback);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedPostback, $event->getPostback());
        $this->assertSame('postback', $event->getName());
    }

    public function testOptinEvent(): void
    {
        $mockedOptin = $this->createMock(Optin::class);
        $event = new OptinEvent('sender_id', 'recipient_id', 123456, $mockedOptin);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedOptin, $event->getOptin());
        $this->assertSame('optin', $event->getName());
    }

    public function testAccountLinkingEvent(): void
    {
        $mockedAccountLinking = $this->createMock(AccountLinking::class);
        $event = new AccountLinkingEvent('sender_id', 'recipient_id', 123456, $mockedAccountLinking);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedAccountLinking, $event->getAccountLinking());
        $this->assertSame('account_linking', $event->getName());
    }

    public function testPaymentEvent(): void
    {
        $mockedPayment = $this->createMock(Payment::class);
        $event = new PaymentEvent('sender_id', 'recipient_id', 123456, $mockedPayment);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedPayment, $event->getPayment());
        $this->assertSame('payment', $event->getName());
    }

    public function testCheckoutUpdate(): void
    {
        $mockedCheckoutUpdate = $this->createMock(CheckoutUpdate::class);
        $event = new CheckoutUpdateEvent('sender_id', 'recipient_id', 123456, $mockedCheckoutUpdate);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedCheckoutUpdate, $event->getCheckoutUpdate());
        $this->assertSame('checkout_update', $event->getName());
    }

    public function testPreCheckout(): void
    {
        $mockedPreCheckout = $this->createMock(PreCheckout::class);
        $event = new PreCheckoutEvent('sender_id', 'recipient_id', 123456, $mockedPreCheckout);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedPreCheckout, $event->getPreCheckout());
        $this->assertSame('pre_checkout', $event->getName());
    }

    public function testPassThreadControl(): void
    {
        $mockedPassThreadControl = $this->createMock(PassThreadControl::class);
        $event = new PassThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedPassThreadControl);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedPassThreadControl, $event->getPassThreadControl());
        $this->assertSame('pass_thread_control', $event->getName());
    }

    public function testRequestThreadControl(): void
    {
        $mockedRequestThreadControl = $this->createMock(RequestThreadControl::class);
        $event = new RequestThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedRequestThreadControl);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedRequestThreadControl, $event->getRequestThreadControl());
        $this->assertSame('request_thread_control', $event->getName());
    }

    public function testTakeThreadControl(): void
    {
        $mockedTakeThreadControl = $this->createMock(TakeThreadControl::class);
        $event = new TakeThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedTakeThreadControl);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedTakeThreadControl, $event->getTakeThreadControl());
        $this->assertSame('take_thread_control', $event->getName());
    }

    public function testPolicyEnforcement(): void
    {
        $mockedPolicyEnforcement = $this->createMock(PolicyEnforcement::class);
        $event = new PolicyEnforcementEvent('sender_id', 'recipient_id', 123456, $mockedPolicyEnforcement);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedPolicyEnforcement, $event->getPolicyEnforcement());
        $this->assertSame('policy_enforcement', $event->getName());
    }

    public function testAppRoles(): void
    {
        $mockedAppRoles = $this->createMock(AppRoles::class);
        $event = new AppRolesEvent('sender_id', 'recipient_id', 123456, $mockedAppRoles);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedAppRoles, $event->getAppRoles());
        $this->assertSame('app_roles', $event->getName());
    }

    public function testGamePlay(): void
    {
        $mockedGamePlay = $this->createMock(GamePlay::class);
        $event = new GamePlayEvent('sender_id', 'recipient_id', 123456, $mockedGamePlay);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedGamePlay, $event->getGamePlay());
        $this->assertSame('game_play', $event->getName());
    }

    public function testRawEvent(): void
    {
        $event = new RawEvent('sender_id', 'recipient_id', ['payload' => 'PAYLOAD']);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(['payload' => 'PAYLOAD'], $event->getRaw());
        $this->assertSame('raw', $event->getName());
    }

    public function testReferralEvent(): void
    {
        $mockedReferral = $this->createMock(Referral::class);
        $event = new ReferralEvent('sender_id', 'recipient_id', 123456, $mockedReferral);

        $this->assertSame('sender_id', $event->getSenderId());
        $this->assertSame('recipient_id', $event->getRecipientId());
        $this->assertSame(123456, $event->getTimestamp());
        $this->assertSame($mockedReferral, $event->getReferral());
        $this->assertSame('referral', $event->getName());
    }
}
