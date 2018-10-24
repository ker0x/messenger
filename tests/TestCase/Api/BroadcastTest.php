<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use Kerox\Messenger\Api\Broadcast;
use Kerox\Messenger\Test\TestCase\ResourceTestCase;

/**
 * Class BroadcastTest
 *
 * @property Broadcast $resource
 */
class BroadcastTest extends ResourceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = new Broadcast($this->client);
    }

    public function testBroadcastCreate(): void
    {
        $mockPath = __DIR__ . '/../../Mocks/Response/Broadcast/message_creatives.json';
        $mockedResponse = $this->createMockedResponse($mockPath);

        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->create('Hello World');

        $this->assertSame('0123456789', $response->getMessageCreativeId());
    }

    public function testBroadcastSend(): void
    {
        $mockPath = __DIR__ . '/../../Mocks/Response/Broadcast/broadcast_messages.json';
        $mockedResponse = $this->createMockedResponse($mockPath);

        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->send('0123456789');

        $this->assertSame('0123456789', $response->getBroadcastId());
    }
}
