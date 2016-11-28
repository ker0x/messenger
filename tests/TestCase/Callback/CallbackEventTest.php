<?php
namespace Kerox\Messenger\Test\TestCase\Callback;

use Kerox\Messenger\Callback\AccountLinkingEvent;
use Kerox\Messenger\Callback\DeliveryEvent;
use Kerox\Messenger\Callback\MessageEchoEvent;
use Kerox\Messenger\Callback\MessageEvent;
use Kerox\Messenger\Callback\OptinEvent;
use Kerox\Messenger\Callback\PostbackEvent;
use Kerox\Messenger\Callback\ReadEvent;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class CalbbackEventTest extends AbstractTestCase
{

    public function testCallbackMessageEvent()
    {
        $mockedMessage = $this->createMock(Message::class);
        $event = new MessageEvent('sender_id', 'recipient_id', 123456, $mockedMessage);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedMessage, $event->getMessage());
    }

    public function testCallbackMessageEchoEvent()
    {
        $mockedMessageEcho = $this->createMock(MessageEcho::class);
        $event = new MessageEchoEvent('sender_id', 'recipient_id', 123456, $mockedMessageEcho);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedMessageEcho, $event->getMessageEcho());
    }

    public function testCallbackReadEvent()
    {
        $mockedRead = $this->createMock(Read::class);
        $event = new ReadEvent('sender_id', 'recipient_id', 123456, $mockedRead);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedRead, $event->getRead());
    }

    public function testCallbackDeliveryEvent()
    {
        $mockedDelivery = $this->createMock(Delivery::class);
        $event = new DeliveryEvent('sender_id', 'recipient_id', $mockedDelivery);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals($mockedDelivery, $event->getDelivery());
    }

    public function testCallbackPostbackEvent()
    {
        $mockedPostback = $this->createMock(Postback::class);
        $event = new PostbackEvent('sender_id', 'recipient_id', 123456, $mockedPostback);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedPostback, $event->getPostback());
    }

    public function testCallbackOptinEvent()
    {
        $mockedOptin = $this->createMock(Optin::class);
        $event = new OptinEvent('sender_id', 'recipient_id', 123456, $mockedOptin);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedOptin, $event->getOptin());
    }

    public function testCallbackAccountLinkingEvent()
    {
        $mockedAccountLinking = $this->createMock(AccountLinking::class);
        $event = new AccountLinkingEvent('sender_id', 'recipient_id', 123456, $mockedAccountLinking);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($mockedAccountLinking, $event->getAccountLinking());
    }
}