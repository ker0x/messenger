<?php
namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\AppRoles;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AppRolesTest extends AbstractTestCase
{

    public function testAppRolesCallback()
    {
        $appRoles = new AppRoles(['123456789' => ['automation']]);

        $this->assertEquals(['123456789' => ['automation']], $appRoles->getAppRoles());
    }
}