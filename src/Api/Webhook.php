<?php
namespace Kerox\Messenger\Api;

use Guzzle\Http\Message\RequestInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Kerox\Messenger\Helper\XHubSignatureHelper;
use Kerox\Messenger\Model\Callback\Entry;
use Kerox\Messenger\Request\WebhookRequest;
use Kerox\Messenger\Response\WebhookResponse;

class Webhook extends AbstractApi
{

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
     * @param string $appSecret
     * @param string $verifyToken
     * @param string $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     * @param \Guzzle\Http\Message\RequestInterface $request
     */
    public function __construct(string $appSecret, string $verifyToken, string $pageToken, ClientInterface $client, RequestInterface $request = null)
    {
        parent::__construct($pageToken, $client);

        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->request = $request ?: ServerRequest::fromGlobals();
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

        return ($params['hub_mode'] === 'subscribe' && $params['hub_verify_token'] === $this->verifyToken);
    }

    /**
     * @return string|null
     */
    public function getChallenge()
    {
        $params = $this->request->getQueryParams();

        return $params['hub_challenge'] ?? null;
    }

    /**
     * @return \Kerox\Messenger\Response\WebhookResponse
     */
    public function sendSubscribe(): WebhookResponse
    {
        $request = new WebhookRequest($this->pageToken);
        $response = $this->client->post('/me/subscribed_apps', $request->build());

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

        return ($object === 'page' && $entry !== null);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getDecodedBody(): array
    {
        if (is_null($this->decodedBody)) {
            $decodedBody = json_decode($this->request->getBody(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error while parsing the request body');
            }

            $this->decodedBody = $decodedBody;
        }

        return $this->decodedBody;
    }

    /**
     * @return \Kerox\Messenger\Model\Entry[]
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
            $events[] += $hydratedEntry->getEvents();
        }

        return $events;
    }

    /**
     * @return array|\Kerox\Messenger\Model\Callback\Entry[]
     */
    private function getHydratedEntries(): array
    {
        if (is_null($this->hydratedEntries)) {
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
        $content = $this->request->getBody();

        if (empty($headers)) {
            return false;
        }

        return XHubSignatureHelper::validate($content, $this->appSecret, $headers[0]);
    }
}
