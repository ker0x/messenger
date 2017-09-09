<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PostbackTest extends AbstractTestCase
{

    public function testPostbackCallback()
    {
        $stub = $this->createMock(Referral::class);
        $postback = new Postback('TITLE_FOR_THE_CTA', 'USER_DEFINED_PAYLOAD', $stub);

        $this->assertEquals('TITLE_FOR_THE_CTA', $postback->getTitle());
        $this->assertTrue($postback->hasPayload());
        $this->assertEquals('USER_DEFINED_PAYLOAD', $postback->getPayload());
        $this->assertTrue($postback->hasReferral());
        $this->assertEquals($stub, $postback->getReferral());
    }

    public function testPostbackCallbackFromStandBy()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/postback_from_stand_by.json');
        $array = json_decode($json, true);

        $postback = Postback::create($array['postback']);

        $this->assertEquals('TITLE_FOR_THE_CTA', $postback->getTitle());
        $this->assertFalse($postback->hasPayload());
        $this->assertNull($postback->getPayload());
        $this->assertFalse($postback->hasReferral());
        $this->assertNull($postback->getReferral());
    }
}