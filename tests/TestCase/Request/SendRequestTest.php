<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\SendInterface;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class SendRequestTest extends AbstractTestCase
{
    public function testBuildMessageRequest()
    {
        $message = Message::create('Hello world');
        $recipient = '1008372609250235';
        $options = [
            SendInterface::OPTION_MESSAGING_TYPE => SendInterface::MESSAGING_TYPE_MESSAGE_TAG,
            SendInterface::OPTION_TAG => SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
        ];

        $request = new SendRequest('me/messages', $message, $recipient, $options);
        $origin = $request->build();

        $expected = json_encode([
            'messaging_type' => SendInterface::MESSAGING_TYPE_MESSAGE_TAG,
            'recipient' => [
                'id' => $recipient,
            ],
            'message' => [
                'text' => 'Hello world',
            ],
            'tag' => SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/messages', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildActionRequest()
    {
        $action = SendInterface::SENDER_ACTION_MARK_SEEN;
        $recipient = '1008372609250235';

        $request = new SendRequest('me/messages', $action, $recipient, [], SendRequest::REQUEST_TYPE_ACTION);
        $origin = $request->build();

        $expected = json_encode([
            'recipient' => [
                'id' => $recipient,
            ],
            'sender_action' => $action,
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/messages', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildAttachmentRequest()
    {
        $attachment = Message\Attachment\Image::create('http://www.messenger-rocks.com/image.jpg', true);
        $message = Message::create($attachment);

        $request = new SendRequest('me/message_attachments', $message);
        $origin = $request->build();

        $expected = json_encode([
            'message' => [
                'attachment' => [
                    'type' => 'image',
                    'payload' => [
                        'url' => 'http://www.messenger-rocks.com/image.jpg',
                        'is_reusable' => true,
                    ],
                ]
            ],
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/message_attachments', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }
}
