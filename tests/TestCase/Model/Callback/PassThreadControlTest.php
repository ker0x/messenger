<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\PassThreadControl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PassThreadControlTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    protected $passThreadControl;

    public function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/pass_thread_control.json');
        $array = json_decode($json, true);

        $this->passThreadControl = PassThreadControl::create($array['pass_thread_control']);
    }

    public function testPassThreadControlCallback(): void
    {
        $this->assertSame('123456789', $this->passThreadControl->getNewOwnerAppId());
        $this->assertSame('additional content that the caller wants to set', $this->passThreadControl->getMetadata());
    }

    public function tearDown(): void
    {
        unset($this->passThreadControl);
    }
}
