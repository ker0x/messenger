<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;

abstract class AbstractApi
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.6';

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
     */
    public function __construct(string $pageToken)
    {
        $this->pageToken = $pageToken;
        $this->client = new Client([
            'base_uri' => self::API_URL . self::API_VERSION,
        ]);
    }
}
