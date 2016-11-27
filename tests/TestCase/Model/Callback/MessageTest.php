<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageTest extends AbstractTestCase
{

    public function testMessageModel()
    {
        $message = new Message('mid.1457764197618:41d102a3e1ae206a38', 73, 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD', [['type' => 'image', 'payload' => ['url' => 'IMAGE_URL']]]);

        $this->assertEquals('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        $this->assertEquals(73, $message->getSequence());
        $this->assertEquals('hello, world!', $message->getText());
        $this->assertEquals('DEVELOPER_DEFINED_PAYLOAD', $message->getQuickReply());
        $this->assertEquals([['type' => 'image', 'payload' => ['url' => 'IMAGE_URL']]], $message->getAttachments());
    }
}