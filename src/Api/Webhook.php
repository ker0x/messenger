<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Kerox\Messenger\Model\Callback\Entry;
use Kerox\Messenger\Request\WebhookRequest;
use Kerox\Messenger\Response\WebhookResponse;
use Psr\Http\Message\ServerRequestInterface;

class Webhook extends AbstractApi
{
    /**
     * @var null|\Kerox\Messenger\Api\Webhook
     */
    private static $_instance;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $verifyToken;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $decodedBody;

    /**
     * @var \Kerox\Messenger\Model\Entry[]
     */
    protected $hydratedEntries;

    /**
     * Webhook constructor.
     *
     * @param string                                   $appSecret
     * @param string                                   $verifyToken
     * @param string                                   $pageToken
     * @param \GuzzleHttp\ClientInterface              $client
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(string $appSecret, string $verifyToken, string $pageToken, ClientInterface $client, ?ServerRequestInterface $request = null)
    {
        parent::__construct($pageToken, $client);

        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->request = $request ?: ServerRequest::fromGlobals();
    }

    /**
     * @param string                                   $appSecret
     * @param string                                   $verifyToken
     * @param string                                   $pageToken
     * @param \GuzzleHttp\ClientInterface              $client
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Kerox\Messenger\Api\Webhook
     */
    public static function getInstance(
        string $appSecret,
        string $verifyToken,
        string $pageToken,
        ClientInterface $client,
        ?ServerRequestInterface $request = null
    ): self {
        if (self::$_instance === null) {
            self::$_instance = new self($appSecret, $verifyToken, $pageToken, $client, $request);
        }

        return self::$_instance;
    }

    /**
     * @return bool
     */
    public function isValidToken(): bool
    {
        if ($this->request->getMethod() !== 'GET') {
            return false;
        }

        $params = $this->request->getQueryParams();
        if (!isset($params['hub_verify_token'])) {
            return false;
        }

        return $params['hub_mode'] === 'subscribe' && $params['hub_verify_token'] === $this->verifyToken;
    }

    /**
     * @return string|null
     */
    public function challenge(): ?string
    {
        $params = $this->request->getQueryParams();

        return $params['hub_challenge'] ?? null;
    }

    /**
     * @return \Kerox\Messenger\Response\WebhookResponse
     */
    public function subscribe(): WebhookResponse
    {
        $request = new WebhookRequest($this->pageToken);
        $response = $this->client->post('me/subscribed_apps', $request->build());

        return new WebhookResponse($response);
    }

    /**
     * @return bool
     */
    public function isValidCallback(): bool
    {
        if (!$this->isValidHubSignature()) {
            return false;
        }

        $decodedBody = $this->getDecodedBody();

        $object = $decodedBody['object'] ?? null;
        $entry = $decodedBody['entry'] ?? null;

        return $object === 'page' && $entry !== null;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        if ($this->body === null) {
            $this->body = (string) $this->request->getBody();
        }

        return $this->body;
    }

    /**
     * @throws \Exception
     *
     * @return array
     */
    public function getDecodedBody(): array
    {
        if ($this->decodedBody === null) {
            $decodedBody = json_decode($this->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE || $decodedBody === null) {
                $decodedBody = [];
            }

            $this->decodedBody = $decodedBody;
        }

        return $this->decodedBody;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Entry[]
     */
    public function getCallbackEntries(): array
    {
        return $this->getHydratedEntries();
    }

    /**
     * @return array
     */
    public function getCallbackEvents(): array
    {
        $events = [];
        foreach ($this->getHydratedEntries() as $hydratedEntry) {
            /** @var \Kerox\Messenger\Model\Callback\Entry $hydratedEntry */
            $events = array_merge($events, $hydratedEntry->getEvents());
        }

        return $events;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Entry[]
     */
    private function getHydratedEntries(): array
    {
        if ($this->hydratedEntries === null) {
            $decodedBody = $this->getDecodedBody();

            $hydrated = [];
            foreach ($decodedBody['entry'] as $entry) {
                $hydrated[] = Entry::create($entry);
            }

            $this->hydratedEntries = $hydrated;
        }

        return $this->hydratedEntries;
    }

    /**
     * @return bool
     */
    private function isValidHubSignature(): bool
    {
        $headers = $this->request->getHeader('X-Hub-Signature');
        $content = $this->getBody();

        if (empty($headers)) {
            return false;
        }

        [$algorithm, $hash] = explode('=', $headers[0]);

        return hash_equals(hash_hmac($algorithm, $content, $this->appSecret), $hash);
    }
}
