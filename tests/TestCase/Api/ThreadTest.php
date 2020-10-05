<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Model\ThreadControl;
use PHPUnit\Framework\TestCase;

class ThreadTest extends TestCase
{
    /**
     * @var \Kerox\Messenger\Api\Thread
     */
    protected $threadApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Thread/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->threadApi = new Thread('abcd1234', $client);
    }

    public function testPassThreadControl(): void
    {
        $passThreadControl = ThreadControl::create(1234567890, 123456789);
        $passThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->threadApi->pass($passThreadControl);

        self::assertTrue($response->isSuccess());
    }

    public function testTakeThreadControl(): void
    {
        $takeThreadControl = ThreadControl::create(1234567890);
        $takeThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->threadApi->take($takeThreadControl);

        self::assertTrue($response->isSuccess());
    }

    public function testRequestThreadControl(): void
    {
        $requestThreadControl = ThreadControl::create(1234567890);
        $requestThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->threadApi->request($requestThreadControl);

        self::assertTrue($response->isSuccess());
    }
}
