<?php

declare(strict_types=1);

namespace Kerox\Messenger;

use GuzzleHttp\HandlerStack;
use Kerox\Messenger\Api\Broadcast;
use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Api\Insights;
use Kerox\Messenger\Api\Nlp;
use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Api\Profile;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Tag;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Api\Webhook;
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
     * @return \Kerox\Messenger\Api\Send
     */
    public function send(): Send
    {
        return new Send($this->client);
    }

    /**
     * @param null|\Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Kerox\Messenger\Api\Webhook
     */
    public function webhook(?ServerRequestInterface $request = null): Webhook
    {
        return new Webhook($this->appSecret, $this->verifyToken, $this->client, $request);
    }

    /**
     * @return \Kerox\Messenger\Api\User
     */
    public function user(): User
    {
        return new User($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Profile
     */
    public function profile(): Profile
    {
        return new Profile($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Code
     */
    public function code(): Code
    {
        return new Code($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Insights
     */
    public function insights(): Insights
    {
        return new Insights($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Tag
     */
    public function tag(): Tag
    {
        return new Tag($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Thread
     */
    public function thread(): Thread
    {
        return new Thread($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Nlp
     */
    public function nlp(): Nlp
    {
        return new Nlp($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Broadcast
     */
    public function broadcast(): Broadcast
    {
        return new Broadcast($this->client);
    }

    /**
     * @return \Kerox\Messenger\Api\Persona
     */
    public function persona(): Persona
    {
        return new Persona($this->client);
    }
}
