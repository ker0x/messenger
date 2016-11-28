<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Callback\MessageEvent;
use Kerox\Messenger\Model\Callback\Entry;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class EntryTest extends AbstractTestCase
{

    public function testEntryModel()
    {
        $payload = [
            'id' => 'PAGE_ID',
            'time' => 1458692752478,
            'messaging' => [
                [
                    'sender' => [
                        'id' => 'USER_ID'
                    ],
                    'recipient' => [
                        'id' => 'PAGE_ID'
                    ],
                    'timestamp' => 1458692752478,
                    'message' => [
                        'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
                        'seq' => 73,
                        'text' => 'hello, world!',
                        'quick_reply' => [
                            'payload' => 'DEVELOPER_DEFINED_PAYLOAD'
                        ]
                    ]
                ]
            ]
        ];

        $messageEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, new Message('mid.1457764197618:41d102a3e1ae206a38', 73, 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD'));
        $entry = Entry::create($payload);

        $this->assertEquals('PAGE_ID', $entry->getId());
        $this->assertEquals(1458692752478, $entry->getTime());
        $this->assertEquals([$messageEvent], $entry->getEvents());
    }
}