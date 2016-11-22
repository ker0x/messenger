<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;
use Kerox\Messenger\Request\WebhookRequest;
use Kerox\Messenger\Response\WebhookResponse;

class Webhook extends AbstractApi
{

    /**
     * Webhook constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\Client $client
     */
    public function __construct($pageToken, Client $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @return \Kerox\Messenger\Response\WebhookResponse
     */
    public function subscribe(): WebhookResponse
    {
        $request = new WebhookRequest($this->pageToken);
        $response = $this->client->post('/me/subscribed_apps', $request->build());

        return new WebhookResponse($response);
    }
}
