<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\ServerRequest;
use Kerox\Messenger\Helper\XHubSignatureHelper;
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
     * Webhook constructor.
     *
     * @param string $appSecret
     * @param string $verifyToken
     * @param string $pageToken
     * @param \GuzzleHttp\Client $client
     * @internal param string $appId
     */
    public function __construct(string $appSecret, string $verifyToken, string $pageToken, Client $client)
    {
        parent::__construct($pageToken, $client);

        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->request = ServerRequest::fromGlobals();
    }

    /**
     * @return bool
     */
    public function verify(): bool
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
    public function challenge()
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
        $response = $this->client->post('/me/subscribed_apps', $request->build());

        return new WebhookResponse($response);
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
