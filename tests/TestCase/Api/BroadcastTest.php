<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Broadcast;
use PHPUnit\Framework\TestCase;

class BroadcastTest extends TestCase
{
    public function testBroadcastCreate(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Broadcast/message_creatives.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $broadcastApi = new Broadcast('abcd1234', $client);

        $response = $broadcastApi->create('Hello World');

        self::assertSame('0123456789', $response->getMessageCreativeId());
    }

    public function testBroadcastSend(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Broadcast/broadcast_messages.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $broadcastApi = new Broadcast('abcd1234', $client);

        $response = $broadcastApi->send('0123456789');

        self::assertSame('0123456789', $response->getBroadcastId());
    }
}
