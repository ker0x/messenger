<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Entry;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class EntryTest extends AbstractTestCase
{

    public function testEntryModel()
    {
        $entry = new Entry('PAGE_ID', 1458692752478, ['messaging' => [0 => ['sender' => ['id' => 'USER_ID'],'recipient' => ['id' => 'PAGE_ID']]]]);

        $this->assertEquals('PAGE_ID', $entry->getId());
        $this->assertEquals(1458692752478, $entry->getTime());
        $this->assertEquals(['messaging' => [0 => ['sender' => ['id' => 'USER_ID'],'recipient' => ['id' => 'PAGE_ID']]]], $entry->getEvents());
    }
}