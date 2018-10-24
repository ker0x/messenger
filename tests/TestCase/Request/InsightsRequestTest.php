<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\InsightsInterface;
use Kerox\Messenger\Request\InsightsRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class InsightsRequestTest extends AbstractTestCase
{
    public function testBuildWithMetricsOnly()
    {
        $metrics = [
            InsightsInterface::ACTIVE_THREAD_UNIQUE,
            InsightsInterface::BLOCKED_CONVERSATIONS_UNIQUE,
        ];

        $request = new InsightsRequest('me/insights', $metrics);
        $origin = $request->build();

        $expected = http_build_query([
            'metric' => implode(',', $metrics),
        ]);

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('me/insights', $origin->getUri()->getPath());
        $this->assertSame($expected, $origin->getUri()->getQuery());
    }

    public function testBuildWithAllParams()
    {
        $metrics = [
            InsightsInterface::ACTIVE_THREAD_UNIQUE,
            InsightsInterface::BLOCKED_CONVERSATIONS_UNIQUE,
        ];

        $request = new InsightsRequest('me/insights', $metrics, 1530323799, 1540323688);
        $origin = $request->build();

        $expected = http_build_query([
            'metric' => implode(',', $metrics),
            'since' => 1530323799,
            'until' => 1540323688,
        ]);

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('me/insights', $origin->getUri()->getPath());
        $this->assertSame($expected, $origin->getUri()->getQuery());
    }
}
