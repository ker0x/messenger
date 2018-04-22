<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message;

use Kerox\Messenger\Model\Message\QuickReply;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class QuickReplyTest extends AbstractTestCase
{

    public function testQuickReplyWithInvalidContentType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid content type');
        $quickReply = QuickReply::create('image');
    }

    public function testQuickReplyWithLocationAndTitle()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Content type must be set to text to use title, payload and image_url');
        $quickReply = QuickReply::create('location')->setTitle('Foo');
    }
}
