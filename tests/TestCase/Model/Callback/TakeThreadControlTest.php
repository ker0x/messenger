<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\TakeThreadControl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TakeThreadControlTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\TakeThreadControl
     */
    protected $takeThreadControl;

    public function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/take_thread_control.json');
        $array = json_decode($json, true);

        $this->takeThreadControl = TakeThreadControl::create($array['take_thread_control']);
    }

    public function testPassThreadControlCallback(): void
    {
        $this->assertSame(123456789, $this->takeThreadControl->getPreviousOwnerAppId());
        $this->assertSame('additional content that the caller wants to set', $this->takeThreadControl->getMetadata());
    }

    public function tearDown(): void
    {
        unset($this->takeThreadControl);
    }
}
