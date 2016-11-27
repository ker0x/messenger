<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class DeliveryTest extends AbstractTestCase
{

    public function testDeliveryModel()
    {
        $delivery = new Delivery(1458668856253, 35, ['mid.1458668856218:ed81099e15d3f4f233']);

        $this->assertEquals(1458668856253, $delivery->getWatermark());
        $this->assertEquals(35, $delivery->getSequence());
        $this->assertEquals(['mid.1458668856218:ed81099e15d3f4f233'], $delivery->getMessageIds());
    }
}