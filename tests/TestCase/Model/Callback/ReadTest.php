<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ReadTest extends AbstractTestCase
{

    public function testReadCallback()
    {
        $read = new Read(1458668856253, 38);

        $this->assertEquals(1458668856253, $read->getWatermark());
        $this->assertEquals(38, $read->getSequence());
    }
}