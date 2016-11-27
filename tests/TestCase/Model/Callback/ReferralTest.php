<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ReferralTest extends AbstractTestCase
{

    public function testReferralModel()
    {
        $referral = new Referral('REF DATA PASSED IN M.ME PARAM', 'SHORTLINK', 'OPEN_THREAD');

        $this->assertEquals('REF DATA PASSED IN M.ME PARAM', $referral->getRef());
        $this->assertEquals('SHORTLINK', $referral->getSource());
        $this->assertEquals('OPEN_THREAD', $referral->getType());
    }
}