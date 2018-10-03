<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageTest extends AbstractTestCase
{
    public function testMessageCallback(): void
    {
        $message = new Message('mid.1457764197618:41d102a3e1ae206a38', 73, 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD', [['type' => 'image', 'payload' => ['url' => 'IMAGE_URL']]]);

        $this->assertSame('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        $this->assertSame(73, $message->getSequence());
        $this->assertSame('hello, world!', $message->getText());
        $this->assertSame('DEVELOPER_DEFINED_PAYLOAD', $message->getQuickReply());
        $this->assertSame([['type' => 'image', 'payload' => ['url' => 'IMAGE_URL']]], $message->getAttachments());
        $this->assertTrue($message->hasText());
        $this->assertTrue($message->hasQuickReply());
        $this->assertTrue($message->hasAttachments());
    }

    public function testMessageModelWithEmptyStringAndEmptyQuickReply(): void
    {
        $message = Message::create([
            'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
            'seq' => 73,
            'text' => '',
            'quick_reply' => [
                'payload' => '',
            ],
            'attachments' => [],
            'entities' => [],
        ]);

        $this->assertSame('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        $this->assertSame(73, $message->getSequence());
        $this->assertSame('', $message->getText());
        $this->assertSame('', $message->getQuickReply());
        $this->assertSame([], $message->getAttachments());
        $this->assertSame([], $message->getEntities());
        $this->assertFalse($message->hasText());
        $this->assertFalse($message->hasQuickReply());
        $this->assertFalse($message->hasAttachments());
        $this->assertFalse($message->hasEntities());
    }
}
