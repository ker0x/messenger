<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\InsightsInterface;
use Kerox\Messenger\Request\InsightsRequest;
use Kerox\Messenger\Response\InsightsResponse;

class Insights extends AbstractApi implements InsightsInterface
{
    /**
     * @var null|\Kerox\Messenger\Api\Insights
     */
    private static $_instance;

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Insights
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param array $metrics
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\InsightsResponse
     */
    public function get(array $metrics = []): InsightsResponse
    {
        $allowedMetrics = $this->getAllowedMetrics();
        if (!empty($allowedMetrics)) {
            foreach ($metrics as $metric) {
                if (!\in_array($metric, $allowedMetrics, true)) {
                    throw new \InvalidArgumentException($metric . ' is not a valid value. $metrics must only contain ' . implode(', ', $allowedMetrics));
                }
            }
        } else {
            $metrics = $allowedMetrics;
        }

        $request = new InsightsRequest($this->pageToken, $metrics);
        $response = $this->client->get('me/insights', $request->build());

        return new InsightsResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedMetrics(): array
    {
        return [
            InsightsInterface::ACTIVE_THREAD_UNIQUE,
            InsightsInterface::BLOCKED_CONVERSATIONS_UNIQUE,
            InsightsInterface::REPORTED_CONVERSATIONS_UNIQUE,
            InsightsInterface::REPORTED_CONVERSATIONS_BY_REPORT_TYPE_UNIQUE,
            InsightsInterface::FEEDBACK_BY_ACTION_UNIQUE,
        ];
    }
}
