<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Response\InsightsResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class InsightsResponseTest extends AbstractTestCase
{

    public function testInsightsResponse()
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Insights/insights.json');

        $response = new Response(200, [], $body);
        $insightsResponse = new InsightsResponse($response);

        $this->assertContainsOnlyInstancesOf(Data::class, $insightsResponse->getData());
    }
}