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
        $allowedMetrics = $this->getAllowedMetrics();
        $metrics = empty($metrics) ? $allowedMetrics : $metrics;

        if ($metrics !== $allowedMetrics) {
            foreach ($metrics as $metric) {
                if (!\in_array($metric, $allowedMetrics, true)) {
                    throw new \InvalidArgumentException(
                        $metric . ' is not a valid value. $metrics must only contain ' . implode(', ', $allowedMetrics)
                    );
                }
            }
        }

        $request = new InsightsRequest($this->pageToken, $metrics, $since, $until);
        $response = $this->client->get('me/insights', $request->build());

        return new InsightsResponse($response);
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
