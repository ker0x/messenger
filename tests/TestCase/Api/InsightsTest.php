<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Insights;
use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\InsightsInterface;
use Kerox\Messenger\Model\Data;

/**
 * Class InsightsTest
 *
 * @property Insights $resource
 */
class InsightsTest extends ResourceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Insights/insights.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Insights($this->client);
    }

    public function testGetInsights(): void
    {
        $metrics = [
            InsightsInterface::ACTIVE_THREAD_UNIQUE,
            InsightsInterface::BLOCKED_CONVERSATIONS_UNIQUE,
        ];

        $response = $this->resource->get($metrics);

        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
    }

    public function testGetInsightsWithBadMetric(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('page_fan_adds_unique is not a valid value. Metrics must only contain "page_messages_active_threads_unique, page_messages_blocked_conversations_unique, page_messages_reported_conversations_unique, page_messages_reported_conversations_by_report_type_unique, page_messages_feedback_by_action_unique".');

        $this->resource->get(['page_fan_adds_unique']);
    }
}
