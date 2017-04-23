<?php

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;

abstract class AbstractApi
{

    /**
     * @var string
     */
    protected $pageToken;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * AbstractApi constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        $this->pageToken = $pageToken;
        $this->client = $client;
    }
}
