<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Message;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Message\QuickReply;
use PHPUnit\Framework\TestCase;

class QuickReplyTest extends TestCase
{
    public function testQuickReplyWithInvalidContentType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('Invalid content type');
        QuickReply::create('image');
    }

    public function testQuickReplyWithLocationAndTitle(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Content type must be set to text to use title, payload and image_url');
        QuickReply::create('location')->setTitle('Foo');
    }
}
