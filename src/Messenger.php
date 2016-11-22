<?php
namespace Kerox\Messenger;

use GuzzleHttp\Client;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Api\Webhook;

class Messenger
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.6';

    /**
     * var string
     */
    protected $pageToken;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Messenger constructor.
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

    /**
     * @return \Kerox\Messenger\Api\Send
     */
    public function send(): Send
    {
        return $this->getApiInstance('Send');
    }

    /**
     * @return \Kerox\Messenger\Api\Webhook
     */
    public function webhook(): Webhook
    {
        return $this->getApiInstance('Webhook');
    }

    /**
     * @return \Kerox\Messenger\Api\User
     */
    public function user(): User
    {
        return $this->getApiInstance('User');
    }

    /**
     * @return \Kerox\Messenger\Api\Thread
     */
    public function thread(): Thread
    {
        return $this->getApiInstance('Thread');
    }

    /**
     * @param string $className
     * @return mixed
     */
    private function getApiInstance(string $className)
    {
        return new $className($this->pageToken, $this->client);
    }
}
