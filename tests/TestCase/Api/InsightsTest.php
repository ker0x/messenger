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
    /**
     * @var \Kerox\Messenger\Api\Insights
     */
    protected $insightsApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Insights/insights.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->insightsApi = new Insights('abcd1234', $client);
    }

    public function testGetInsights()
    {
        $response = $this->insightsApi->get();

        $this->assertInstanceOf(InsightsResponse::class, $response);
        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
    }

    public function testGetInsightsWithBadMetric()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('page_fan_adds_unique is not a valid value. $metrics must only contain page_messages_active_threads_unique, page_messages_blocked_conversations_unique, page_messages_reported_conversations_unique, page_messages_reported_conversations_by_report_type_unique, page_messages_feedback_by_action_unique');
        $response = $this->insightsApi->get(['page_fan_adds_unique']);
    }
}