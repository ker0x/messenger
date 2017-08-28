<?php
namespace Kerox\Messenger\Test\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Model\ThreadControl;
use Kerox\Messenger\Response\ThreadResponse;

class ThreadTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Api\Thread
     */
    protected $threadApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Thread/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->threadApi = new Thread('abcd1234', $client);
    }

    public function testPassThreadControl()
    {
        $passThreadControl = new ThreadControl(1234567890, 123456789);

        $response = $this->threadApi->pass($passThreadControl);

        $this->assertInstanceOf(ThreadResponse::class, $response);
        $this->assertTrue($response->isSuccess());
    }

    public function testTakeThreadControl()
    {
        $takeThreadControl = new ThreadControl(1234567890);

        $response = $this->threadApi->take($takeThreadControl);

        $this->assertInstanceOf(ThreadResponse::class, $response);
        $this->assertTrue($response->isSuccess());
    }
}