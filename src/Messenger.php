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
     * @var \Kerox\Messenger\Api\Send
     */
    protected $sendApi;

    /**
     * @var \Kerox\Messenger\Api\Webhook
     */
    protected $webhookApi;

    /**
     * @var \Kerox\Messenger\Api\User
     */
    protected $userApi;

    /**
     * @var \Kerox\Messenger\Api\Thread
     */
    protected $threadApi;

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
        if ($this->sendApi === null) {
            $this->sendApi = $this->getApiInstance('Send');
        }

        return $this->sendApi;
    }

    /**
     * @param string $appSecret
     * @param string $verifyToken
     * @return \Kerox\Messenger\Api\Webhook
     */
    public function webhook(string $appSecret = null, string $verifyToken = null): Webhook
    {
        if ($this->webhookApi === null && $appSecret !== null && $verifyToken !== null) {
            $this->webhookApi = new Webhook($appSecret, $verifyToken, $this->pageToken, $this->client);
        }

        return $this->webhookApi;
    }

    /**
     * @return \Kerox\Messenger\Api\User
     */
    public function user(): User
    {
        if ($this->userApi === null) {
            $this->userApi = $this->getApiInstance('User');
        }

        return $this->userApi;
    }

    /**
     * @return \Kerox\Messenger\Api\Thread
     */
    public function thread(): Thread
    {
        if ($this->threadApi === null) {
            $this->threadApi = $this->getApiInstance('Thread');
        }

        return $this->threadApi;
    }

    /**
     * @param string $className
     * @return mixed
     */
    private function getApiInstance(string $className)
    {
        $class = __NAMESPACE__ . '\\Api\\' . $className;

        return new $class($this->pageToken, $this->client);
    }
}
