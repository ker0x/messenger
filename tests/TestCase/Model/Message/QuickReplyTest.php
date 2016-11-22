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
        $quickReply = new QuickReply('image');
    }

    public function testQuickReplyWithLocationAndTitle()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Content type is set to location');
        $quickReply = (new QuickReply('location'))->setTitle('Foo');
    }
}