<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Request\TagRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TagRequestTest extends AbstractTestCase
{
    public function testBuild()
    {
        $request = new TagRequest('page_message_tags');
        $origin = $request->build();

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('page_message_tags', $origin->getUri()->getPath());
        $this->assertSame('', $origin->getUri()->getQuery());
    }
}
