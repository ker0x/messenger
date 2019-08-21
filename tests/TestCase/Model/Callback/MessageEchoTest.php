<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageEchoTest extends AbstractTestCase
{
    public function testMessageEchoCallback(): void
    {
        $messageEcho = new MessageEcho(
            true,
            1517776481860111,
            'mid.1457764197618:41d102a3e1ae206a38',
            'DEVELOPER_DEFINED_METADATA_STRING'
        );

        $this->assertTrue($messageEcho->isEcho());
        $this->assertSame(1517776481860111, $messageEcho->getAppId());
        $this->assertSame('DEVELOPER_DEFINED_METADATA_STRING', $messageEcho->getMetadata());
        $this->assertSame('mid.1457764197618:41d102a3e1ae206a38', $messageEcho->getMessageId());
    }
}
