<?php

declare(strict_types=1);

namespace Kerox\Messenger;

use GuzzleHttp\HandlerStack;
use Kerox\Messenger\Api;
use Kerox\Messenger\Http\Client;
use Kerox\Messenger\Http\Middleware;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ServerRequestInterface;

class Messenger
{
    public const API_URL = 'https://graph.facebook.com/';
    public const API_VERSION = 'v3.1';

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
     * @var ClientInterface
     */
    protected $client;

    /**
     * Messenger constructor.
     *
     * @param string          $appSecret
     * @param string          $verifyToken
     * @param string          $pageToken
     * @param string          $apiVersion
     * @param ClientInterface $client
     */
    public function __construct(
        string $appSecret,
        string $verifyToken,
        string $pageToken,
        string $apiVersion = self::API_VERSION,
        ?ClientInterface $client = null
    ) {
        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->pageToken = $pageToken;

        if ($client === null) {
            $client = $this->createClient($apiVersion);
        }
        $this->client = $client;
    }

    /**
     * @param string $apiVersion
     *
     * @return ClientInterface
     */
    private function createClient(string $apiVersion): ClientInterface
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::header('Content-Type', 'application/json'));
        $stack->push(Middleware::queryParam('access_token', $this->pageToken));

        return new Client([
            'handler' => $stack,
            'base_uri' => self::API_URL . $apiVersion . '/',
        ]);
    }

    /**
     * @return Api\Send
     */
    public function send(): Api\Send
    {
        return new Api\Send($this->client);
    }

    /**
     * @param null|\Psr\Http\Message\ServerRequestInterface $request
     *
     * @return Api\Webhook
     */
    public function webhook(?ServerRequestInterface $request = null): Api\Webhook
    {
        return new Api\Webhook($this->appSecret, $this->verifyToken, $this->client, $request);
    }

    /**
     * @return Api\User
     */
    public function user(): Api\User
    {
        return new Api\User($this->client);
    }

    /**
     * @return Api\Profile
     */
    public function profile(): Api\Profile
    {
        return new Api\Profile($this->client);
    }

    /**
     * @return Api\Code
     */
    public function code(): Api\Code
    {
        return new Api\Code($this->client);
    }

    /**
     * @return Api\Insights
     */
    public function insights(): Api\Insights
    {
        return new Api\Insights($this->client);
    }

    /**
     * @return Api\Tag
     */
    public function tag(): Api\Tag
    {
        return new Api\Tag($this->client);
    }

    /**
     * @return Api\Thread
     */
    public function thread(): Api\Thread
    {
        return new Api\Thread($this->client);
    }

    /**
     * @return Api\Nlp
     */
    public function nlp(): Api\Nlp
    {
        return new Api\Nlp($this->client);
    }

    /**
     * @return Api\Broadcast
     */
    public function broadcast(): Api\Broadcast
    {
        return new Api\Broadcast($this->client);
    }

    /**
     * @return Api\Persona
     */
    public function persona(): Api\Persona
    {
        return new Api\Persona($this->client);
    }
}
