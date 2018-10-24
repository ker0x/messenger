<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Request\UserRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Kerox\Messenger\UserInterface;

class UserRequestTest extends AbstractTestCase
{
    public function testBuild()
    {
        $fields = [
            UserInterface::FIRST_NAME,
            UserInterface::LAST_NAME,
        ];

        $request = new UserRequest('test', $fields);
        $origin = $request->build();

        $expected = http_build_query([
            'fields' => implode(',', $fields),
        ]);

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('test', $origin->getUri()->getPath());
        $this->assertSame($expected, $origin->getUri()->getQuery());
    }
}
