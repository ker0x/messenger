<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\PolicyEnforcement;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PolicyEnforcementTest extends AbstractTestCase
{
    public function testPolicyEnforcementCallback(): void
    {
        $policyEnforcement = new PolicyEnforcement('block', 'The bot violated our Platform Policies (https://developers.facebook.com/policy/#messengerplatform). Common violations include sending out excessive spammy messages or being non-functional.');

        $this->assertSame('block', $policyEnforcement->getAction());
        $this->assertSame('The bot violated our Platform Policies (https://developers.facebook.com/policy/#messengerplatform). Common violations include sending out excessive spammy messages or being non-functional.', $policyEnforcement->getReason());
    }
}
