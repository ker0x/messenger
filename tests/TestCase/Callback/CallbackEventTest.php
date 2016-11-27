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
        $stub = $this->createMock(Message::class);
        $event = new MessageEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getMessage());
    }

    public function testCallbackMessageEchoEvent()
    {
        $stub = $this->createMock(MessageEcho::class);
        $event = new MessageEchoEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getMessageEcho());
    }

    public function testCallbackReadEvent()
    {
        $stub = $this->createMock(Read::class);
        $event = new ReadEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getRead());
    }

    public function testCallbackDeliveryEvent()
    {
        $stub = $this->createMock(Delivery::class);
        $event = new DeliveryEvent('sender_id', 'recipient_id', $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals($stub, $event->getDelivery());
    }

    public function testCallbackPostbackEvent()
    {
        $stub = $this->createMock(Postback::class);
        $event = new PostbackEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getPostback());
    }

    public function testCallbackOptinEvent()
    {
        $stub = $this->createMock(Optin::class);
        $event = new OptinEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getOptin());
    }

    public function testCallbackAccountLinkingEvent()
    {
        $stub = $this->createMock(AccountLinking::class);
        $event = new AccountLinkingEvent('sender_id', 'recipient_id', 123456, $stub);

        $this->assertEquals('sender_id', $event->getSenderId());
        $this->assertEquals('recipient_id', $event->getRecipientId());
        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals($stub, $event->getAccountLinking());
    }
}