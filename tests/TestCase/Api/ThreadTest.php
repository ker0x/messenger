<?php
namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Model\ThreadSettings\Greeting;
use Kerox\Messenger\Response\ThreadResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ThreadTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\Thread
     */
    protected $threadApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Thread/result.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->threadApi = new Thread('abcd1234', $client);
    }

    public function testAddSetting()
    {
        $greeting = new Greeting('Timeless apparel for the masses.');

        $response = $this->threadApi->addSetting($greeting);

        $this->assertInstanceOf(ThreadResponse::class, $response);
    }

    public function testRemoveSetting()
    {
        $this->threadApi->deleteSetting('call_to_actions', 'existing_thread');

        $this->doesNotPerformAssertions();
    }

    public function testBadState()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$state must be either new_thread, existing_thread');
        $this->threadApi->deleteSetting('call_to_actions', 'update_thread');
    }
}