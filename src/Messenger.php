<?php
namespace Kerox\Messenger;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Api\Webhook;
use Psr\Http\Message\ServerRequestInterface;

class Messenger
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.8';

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $verifyToken;

    /**
     * @var string
     */
    protected $pageToken;

    /**
     * @var \GuzzleHttp\ClientInterface
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
     * @var \Kerox\Messenger\Api\Code
     */
    protected $codeApi;

    /**
     * Messenger constructor.
     *
     * @param string $appSecret
     * @param string $verifyToken
     * @param string $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $appSecret, string $verifyToken, string $pageToken, ClientInterface $client = null)
    {
        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->pageToken = $pageToken;

        if ($client === null) {
            $client = new Client([
                'base_uri' => self::API_URL . self::API_VERSION . '/',
            ]);
        }
        $this->client = $client;
    }

    /**
     * @return \Kerox\Messenger\Api\Send
     */
    public function send(): Send
    {
        if ($this->sendApi === null) {
            $this->sendApi = new Send($this->pageToken, $this->client);
        }

        return $this->sendApi;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Kerox\Messenger\Api\Webhook
     */
    public function webhook(ServerRequestInterface $request = null): Webhook
    {
        if ($this->webhookApi === null) {
            $this->webhookApi = new Webhook($this->appSecret, $this->verifyToken, $this->pageToken, $this->client, $request);
        }

        return $this->webhookApi;
    }

    /**
     * @return \Kerox\Messenger\Api\User
     */
    public function user(): User
    {
        if ($this->userApi === null) {
            $this->userApi = new User($this->pageToken, $this->client);
        }

        return $this->userApi;
    }

    /**
     * @return \Kerox\Messenger\Api\Thread
     */
    public function thread(): Thread
    {
        if ($this->threadApi === null) {
            $this->threadApi = new Thread($this->pageToken, $this->client);
        }

        return $this->threadApi;
    }

    /**
     * @return \Kerox\Messenger\Api\Code
     */
    public function code(): Code
    {
        if ($this->codeApi === null) {
            $this->codeApi = new Code($this->pageToken, $this->client);
        }

        return $this->codeApi;
    }
}
