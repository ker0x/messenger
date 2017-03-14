<?php
namespace Kerox\Messenger\Test\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Insights;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Response\InsightsResponse;

class InsightsTest extends AbstractTestCase
{

    public function testThreads()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Insights/page_messages_active_threads_unique.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $insightsApi = new Insights('abcd1234', $client);
        $response = $insightsApi->threads();

        $this->assertInstanceOf(InsightsResponse::class, $response);
        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
    }

    public function testFeedback()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Insights/page_messages_feedback_by_action_unique.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $insightsApi = new Insights('abcd1234', $client);
        $response = $insightsApi->feedback();

        $this->assertInstanceOf(InsightsResponse::class, $response);
        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
    }
}