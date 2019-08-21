<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class DeliveryTest extends AbstractTestCase
{
    public function testDeliveryCallback(): void
    {
        $delivery = new Delivery(1458668856253, ['mid.1458668856218:ed81099e15d3f4f233']);

        $this->assertSame(1458668856253, $delivery->getWatermark());
        $this->assertSame(['mid.1458668856218:ed81099e15d3f4f233'], $delivery->getMessageIds());
    }
}
