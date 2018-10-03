<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ReferralTest extends AbstractTestCase
{
    public function testReferralCallback(): void
    {
        $referral = new Referral('REF DATA PASSED IN M.ME PARAM', 'SHORTLINK', 'OPEN_THREAD');

        $this->assertSame('REF DATA PASSED IN M.ME PARAM', $referral->getRef());
        $this->assertSame('SHORTLINK', $referral->getSource());
        $this->assertSame('OPEN_THREAD', $referral->getType());
    }
}
