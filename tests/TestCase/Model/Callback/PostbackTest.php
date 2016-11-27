<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PostbackTest extends AbstractTestCase
{

    public function testPostbackModel()
    {
        $stub = $this->createMock(Referral::class);
        $postback = new Postback('USER_DEFINED_PAYLOAD', $stub);

        $this->assertEquals('USER_DEFINED_PAYLOAD', $postback->getPayload());
        $this->assertEquals($stub, $postback->getReferral());
    }
}