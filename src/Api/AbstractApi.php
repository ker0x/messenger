<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;

abstract class AbstractApi
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.6';

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
