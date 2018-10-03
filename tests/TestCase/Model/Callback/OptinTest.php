<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class OptinTest extends AbstractTestCase
{
    public function testOptinCallback(): void
    {
        $optin = new Optin('PASS_THROUGH_PARAM');

        $this->assertSame('PASS_THROUGH_PARAM', $optin->getRef());
    }
}
