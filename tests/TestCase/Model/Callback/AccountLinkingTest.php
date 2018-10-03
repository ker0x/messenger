<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AccountLinkingTest extends AbstractTestCase
{
    public function testAccountLinkingCallback(): void
    {
        $accountLinking = new AccountLinking('linked', 'PASS_THROUGH_AUTHORIZATION_CODE');

        $this->assertSame('linked', $accountLinking->getStatus());
        $this->assertTrue($accountLinking->hasAuthorizationCode());
        $this->assertSame('PASS_THROUGH_AUTHORIZATION_CODE', $accountLinking->getAuthorizationCode());
    }
}
