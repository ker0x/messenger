<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
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

        self::assertSame('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        self::assertSame('', $message->getText());
        self::assertSame('', $message->getQuickReply());
        self::assertSame([], $message->getAttachments());
        self::assertSame([], $message->getEntities());
        self::assertSame([], $message->getTraits());
        self::assertSame([], $message->getDetectedLocales());
        self::assertFalse($message->hasText());
        self::assertFalse($message->hasQuickReply());
        self::assertFalse($message->hasAttachments());
        self::assertFalse($message->hasEntities());
        self::assertFalse($message->hasTraits());
        self::assertFalse($message->hasDetectedLocales());
    }
}
