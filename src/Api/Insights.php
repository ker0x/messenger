<?php

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Request\InsightsRequest;
use Kerox\Messenger\Response\InsightsResponse;

class Insights extends AbstractApi
{
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
