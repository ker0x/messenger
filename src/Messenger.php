<?php
namespace Kerox\Messenger;

use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Api\Webhook;

class Messenger
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.6';

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
     * @param string $appSecret
     * @param string $verifyToken
     * @param string $pageToken
     */
    public function __construct(string $appSecret, string $verifyToken, string $pageToken)
    {
        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->pageToken = $pageToken;
    }

    /**
     * @return \Kerox\Messenger\Api\Send
     */
    public function send(): Send
    {
        if ($this->sendApi === null) {
            $this->sendApi = new Send($this->pageToken);
        }

        return $this->sendApi;
    }

    /**
     * @return \Kerox\Messenger\Api\Webhook
     */
    public function webhook(): Webhook
    {
        if ($this->webhookApi === null) {
            $this->webhookApi = new Webhook($this->appSecret, $this->verifyToken, $this->pageToken);
        }

        return $this->webhookApi;
    }

    /**
     * @return \Kerox\Messenger\Api\User
     */
    public function user(): User
    {
        if ($this->userApi === null) {
            $this->userApi = new User($this->pageToken);
        }

        return $this->userApi;
    }

    /**
     * @return \Kerox\Messenger\Api\Thread
     */
    public function thread(): Thread
    {
        if ($this->threadApi === null) {
            $this->threadApi = new Thread($this->pageToken);
        }

        return $this->threadApi;
    }
}
