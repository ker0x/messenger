<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\ThreadResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ThreadResponseTest extends AbstractTestCase
{

    public function testThreadResponse()
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Thread/result.json');

        $response = new Response(200, [], $body);
        $threadResponse = new ThreadResponse($response);

        $this->assertEquals('Successfully added new_thread\'s CTAs', $threadResponse->getResult());
    }
}