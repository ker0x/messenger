<?php

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Request\InsightsRequest;
use Kerox\Messenger\Response\InsightsResponse;

class Insights extends AbstractApi
{
    /**
     * @var null|\Kerox\Messenger\Api\Insights
     */
    private static $_instance;

    /**
     * Insights constructor.
     *
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        parent::__construct($pageToken, $client);
    }

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
     * @return \Kerox\Messenger\Response\InsightsResponse
     */
    public function threads(): InsightsResponse
    {
        $request = new InsightsRequest($this->pageToken);
        $response = $this->client->get('me/insights/page_messages_active_threads_unique', $request->build());

        return new InsightsResponse($response);
    }

    /**
     * @return \Kerox\Messenger\Response\InsightsResponse
     */
    public function feedback(): InsightsResponse
    {
        $request = new InsightsRequest($this->pageToken);
        $response = $this->client->get('me/insights/page_messages_feedback_by_action_unique', $request->build());

        return new InsightsResponse($response);
    }
}
