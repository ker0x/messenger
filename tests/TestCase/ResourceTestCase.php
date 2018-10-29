<?php

namespace Kerox\Messenger\Test\TestCase;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\AbstractApi;
use Kerox\Messenger\Http\Client;

abstract class ResourceTestCase extends AbstractTestCase
{
    /**
     * @var AbstractApi
     */
    protected $resource;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var MockHandler
     */
    protected $mockHandler;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $stack = HandlerStack::create($this->mockHandler);

        $this->client = new Client([
            'handler' => $stack,
        ]);
    }

    protected function tearDown(): void
    {
        $this->resource = null;
    }

    /**
     * @param string $mockPath
     *
     * @return Response
     */
    protected function createMockedResponse(string $mockPath): Response
    {
        $content = file_get_contents($mockPath);

        return new Response(200, [], $content);
    }
}
