<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;

abstract class AbstractApi
{

    /**
     * @var string
     */
    protected $pageToken;

    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractApi constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(string $pageToken, Client $client)
    {
        $this->pageToken = $pageToken;
        $this->client = $client;
    }
}
