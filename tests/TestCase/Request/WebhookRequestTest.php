<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Request\WebhookRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class WebhookRequestTest extends AbstractTestCase
{
    public function testBuild()
    {
        $request = new WebhookRequest('me/subscribed_apps');
        $origin = $request->build();

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('me/subscribed_apps', $origin->getUri()->getPath());
        $this->assertSame('', $origin->getUri()->getQuery());
    }
}
