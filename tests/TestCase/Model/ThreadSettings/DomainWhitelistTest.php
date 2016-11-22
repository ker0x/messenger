<?php
namespace Kerox\Messenger\Test\TestCase\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings\DomainWhitelist;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class DomainWhitelistTest extends AbstractTestCase
{

    public function testInvalidActionType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$actionType must be either add, remove');
        $domainWhitelist = new DomainWhitelist(['http://example.com'], 'update');
    }
}