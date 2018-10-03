<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PostbackTest extends AbstractTestCase
{
    public function testPostbackCallback(): void
    {
        $stub = $this->createMock(Referral::class);
        $postback = new Postback('TITLE_FOR_THE_CTA', 'USER_DEFINED_PAYLOAD', $stub);

        $this->assertSame('TITLE_FOR_THE_CTA', $postback->getTitle());
        $this->assertTrue($postback->hasPayload());
        $this->assertSame('USER_DEFINED_PAYLOAD', $postback->getPayload());
        $this->assertTrue($postback->hasReferral());
        $this->assertSame($stub, $postback->getReferral());
    }

    public function testPostbackCallbackFromStandBy(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/postback_from_stand_by.json');
        $array = json_decode($json, true);

        $postback = Postback::create($array['postback']);

        $this->assertSame('TITLE_FOR_THE_CTA', $postback->getTitle());
        $this->assertFalse($postback->hasPayload());
        $this->assertNull($postback->getPayload());
        $this->assertFalse($postback->hasReferral());
        $this->assertNull($postback->getReferral());
    }
}
