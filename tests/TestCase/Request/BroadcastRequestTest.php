<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Request\BroadcastRequest;
use Kerox\Messenger\SendInterface;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class BroadcastRequestTest extends AbstractTestCase
{
    public function testBuildWithMessageOnly()
    {
        $message = Message::create('Hello world');
        $request = new BroadcastRequest('me/message_creatives', $message);
        $origin = $request->build();

        $expected = json_encode([
            'messages' => [
                $message
            ],
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/message_creatives', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildWithMessageCreativeIdAndOptions()
    {
        $messageCreativeId = '1712444532121303';
        $options = [
            SendInterface::OPTION_MESSAGING_TYPE => SendInterface::MESSAGING_TYPE_MESSAGE_TAG,
            SendInterface::OPTION_NOTIFICATION_TYPE => SendInterface::NOTIFICATION_TYPE_REGULAR,
            SendInterface::OPTION_TAG => SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
        ];

        $request = new BroadcastRequest('me/broadcast_messages', null, $messageCreativeId, $options);
        $origin = $request->build();

        $expected = json_encode([
            'message_creative_id' => $messageCreativeId,
            SendInterface::OPTION_MESSAGING_TYPE => SendInterface::MESSAGING_TYPE_MESSAGE_TAG,
            SendInterface::OPTION_NOTIFICATION_TYPE => SendInterface::NOTIFICATION_TYPE_REGULAR,
            SendInterface::OPTION_TAG => SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/broadcast_messages', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }
}
