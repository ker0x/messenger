<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AccountLinkingTest extends AbstractTestCase
{

    public function testAccountLinkingModel()
    {
        $accountLinking = new AccountLinking('linked', 'PASS_THROUGH_AUTHORIZATION_CODE');

        $this->assertEquals('linked', $accountLinking->getStatus());
        $this->assertEquals('PASS_THROUGH_AUTHORIZATION_CODE', $accountLinking->getAuthorizationCode());
    }
}