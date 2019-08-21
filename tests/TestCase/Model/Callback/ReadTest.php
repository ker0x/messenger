<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ReadTest extends AbstractTestCase
{
    public function testReadCallback(): void
    {
        $read = new Read(1458668856253);

        $this->assertSame(1458668856253, $read->getWatermark());
    }
}
