<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;

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
}
