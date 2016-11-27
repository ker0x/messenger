<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageEchoTest extends AbstractTestCase
{

    public function testMessageEchoModel()
    {
        $messageEcho = new MessageEcho(true, 1517776481860111, 'mid.1457764197618:41d102a3e1ae206a38', 73, 'DEVELOPER_DEFINED_METADATA_STRING');

        $this->assertTrue($messageEcho->isEcho());
        $this->assertEquals(1517776481860111, $messageEcho->getAppId());
        $this->assertEquals('DEVELOPER_DEFINED_METADATA_STRING', $messageEcho->getMetadata());
        $this->assertEquals('mid.1457764197618:41d102a3e1ae206a38', $messageEcho->getMessageId());
        $this->assertEquals(73, $messageEcho->getSequence());
    }
}