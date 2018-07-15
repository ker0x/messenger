<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\InsightsInterface;
use Kerox\Messenger\Request\InsightsRequest;
use Kerox\Messenger\Response\InsightsResponse;

class Insights extends AbstractApi implements InsightsInterface
{
    /**
     * @param array    $metrics
     * @param null|int $since
     * @param null|int $until
     *
     * @return \Kerox\Messenger\Response\InsightsResponse
     */
    public function get(array $metrics = [], ?int $since = null, ?int $until = null): InsightsResponse
    {
        $metrics = $this->isValidMetrics($metrics);

        $request = new InsightsRequest($this->pageToken, $metrics, $since, $until);
        $response = $this->client->get('me/insights', $request->build());

        return new InsightsResponse($response);
    }

    /**
     * @param array $metrics
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    private function isValidMetrics(array $metrics): array
    {
        $allowedMetrics = $this->getAllowedMetrics();

        $metrics = empty($metrics) ? $allowedMetrics : $metrics;
        if ($metrics !== $allowedMetrics) {
            array_map(function ($metric) use ($allowedMetrics): void {
                if (!\in_array($metric, $allowedMetrics, true)) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s is not a valid value. $metrics must only contain %s',
                        $metric,
                        implode(', ', $allowedMetrics)
                    ));
                }
            }, $metrics);
        }

        return $metrics;
    }

    /**
     * @return array
     */
    private function getAllowedMetrics(): array
    {
        return [
            self::ACTIVE_THREAD_UNIQUE,
            self::BLOCKED_CONVERSATIONS_UNIQUE,
            self::REPORTED_CONVERSATIONS_UNIQUE,
            self::REPORTED_CONVERSATIONS_BY_REPORT_TYPE_UNIQUE,
            self::FEEDBACK_BY_ACTION_UNIQUE,
        ];
    }
}
