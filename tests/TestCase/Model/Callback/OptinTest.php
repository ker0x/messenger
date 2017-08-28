<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class OptinTest extends AbstractTestCase
{

    public function testOptinCallback()
    {
        $optin = new Optin('PASS_THROUGH_PARAM');

        $this->assertEquals('PASS_THROUGH_PARAM', $optin->getRef());
    }
}