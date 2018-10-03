<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\AppRoles;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AppRolesTest extends AbstractTestCase
{
    public function testAppRolesCallback(): void
    {
        $appRoles = new AppRoles(['123456789' => ['automation']]);

        $this->assertSame(['123456789' => ['automation']], $appRoles->getAppRoles());
    }
}
