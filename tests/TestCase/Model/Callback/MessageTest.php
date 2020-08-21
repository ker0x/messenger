<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageTest extends AbstractTestCase
{
    public function testMessageModelWithEmptyStringAndEmptyQuickReply(): void
    {
        $message = Message::create([
            'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
            'text' => '',
            'quick_reply' => [
                'payload' => '',
            ],
            'attachments' => [],
            'entities' => [],
            'traits' => [],
            'detected_locales' => [],
        ]);

        $this->assertSame('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        $this->assertSame('', $message->getText());
        $this->assertSame('', $message->getQuickReply());
        $this->assertSame([], $message->getAttachments());
        $this->assertSame([], $message->getEntities());
        $this->assertSame([], $message->getTraits());
        $this->assertSame([], $message->getDetectedLocales());
        $this->assertFalse($message->hasText());
        $this->assertFalse($message->hasQuickReply());
        $this->assertFalse($message->hasAttachments());
        $this->assertFalse($message->hasEntities());
        $this->assertFalse($message->hasTraits());
        $this->assertFalse($message->hasDetectedLocales());
    }
}
