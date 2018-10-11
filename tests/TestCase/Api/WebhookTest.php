<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Kerox\Messenger\Api\Webhook;
use Kerox\Messenger\Event\MessageEvent;
use Kerox\Messenger\Http\Client;
use Kerox\Messenger\Model\Callback\Entry;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class WebhookTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Api\Webhook
     */
    protected $webhookApi;

    public function setUp(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $requestBody = file_get_contents(__DIR__ . '/../../Mocks/Callback/message.json');
        $requestHeaders = [
            'Content-Type' => 'application/json',
            'X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', $requestBody, $appSecret),
        ];

        $request = new ServerRequest('POST', '/app.php/facebook/webhook', $requestHeaders, $requestBody);

        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Webhook/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->webhookApi = new Webhook($appSecret, $verifyToken, $client, $request);
    }

    public function testSubscribe(): void
    {
        $response = $this->webhookApi->subscribe();

        $this->assertTrue($response->isSuccess());
    }

    public function testWebhookVerification(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $client = new Client();

        $params = ['hub_mode' => 'subscribe', 'hub_verify_token' => $verifyToken, 'hub_challenge' => '1234abcd'];
        $request = (new ServerRequest('GET', '/'))->withQueryParams($params);

        $webhook = new Webhook($appSecret, $verifyToken, $client, $request);

        $this->assertTrue($webhook->isValidToken());
        $this->assertSame('1234abcd', $webhook->challenge());
    }

    public function testIsValidCallback(): void
    {
        $this->assertTrue($this->webhookApi->isValidCallback());
    }

    public function testGetDecodedBody(): void
    {
        $body = [
            'object' => 'page',
            'entry' => [
                [
                    'id' => '625987814267888',
                    'time' => 1480331915260,
                    'messaging' => [
                        [
                            'sender' => [
                                'id' => 'USER_ID',
                            ],
                            'recipient' => [
                                'id' => 'PAGE_ID',
                            ],
                            'timestamp' => 1458692752478,
                            'message' => [
                                'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
                                'seq' => 73,
                                'text' => 'hello, world!',
                                'quick_reply' => [
                                    'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertSame($body, $this->webhookApi->getDecodedBody());
    }

    public function testGetCallbackEntries(): void
    {
        $payload = [
            'id' => '625987814267888',
            'time' => 1480331915260,
            'messaging' => [
                [
                    'sender' => [
                        'id' => 'USER_ID',
                    ],
                    'recipient' => [
                        'id' => 'PAGE_ID',
                    ],
                    'timestamp' => 1458692752478,
                    'message' => [
                        'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
                        'seq' => 73,
                        'text' => 'hello, world!',
                        'quick_reply' => [
                            'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                        ],
                    ],
                ],
            ],
        ];

        $entry = Entry::create($payload);

        $entries = $this->webhookApi->getCallbackEntries();

        $this->assertEquals([$entry], $entries);
    }

    public function testGetCallbackEvents(): void
    {
        $event = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, new Message('mid.1457764197618:41d102a3e1ae206a38', 73, 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD'));

        $events = $this->webhookApi->getCallbackEvents();

        $this->assertEquals([$event], $events);
    }

    public function testStandbyEntry(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $requestBody = file_get_contents(__DIR__ . '/../../Mocks/Callback/stand_by.json');
        $requestHeaders = [
            'Content-Type' => 'application/json',
            'X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', $requestBody, $appSecret),
        ];

        $request = new ServerRequest('POST', '/app.php/facebook/webhook', $requestHeaders, $requestBody);

        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Webhook/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $event = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, new Message('mid.1457764197618:41d102a3e1ae206a38', 73, 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD'));

        $webhookApi = new Webhook($appSecret, $verifyToken, $client, $request);
        $events = $webhookApi->getCallbackEvents();

        $this->assertEquals([$event], $events);
    }

    public function testWebhookVerificationWithInvalidRequestMethod(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $client = new Client();

        $params = ['hub_mode' => 'subscribe', 'hub_verify_token' => $verifyToken, 'hub_challenge' => '1234abcd'];
        $request = (new ServerRequest('POST', '/'))->withQueryParams($params);

        $webhook = new Webhook($appSecret, $verifyToken, $client, $request);

        $this->assertFalse($webhook->isValidToken());
    }

    public function testWebhookVerificationWithMissingParam(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $client = new Client();

        $params = ['hub_mode' => 'subscribe', 'hub_challenge' => '1234abcd'];
        $request = (new ServerRequest('GET', '/'))->withQueryParams($params);

        $webhook = new Webhook($appSecret, $verifyToken, $client, $request);

        $this->assertFalse($webhook->isValidToken());
    }

    public function testWebhookWithMissingHeaders(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $requestBody = file_get_contents(__DIR__ . '/../../Mocks/Callback/stand_by.json');
        $requestHeaders = [];

        $request = new ServerRequest('POST', '/app.php/facebook/webhook', $requestHeaders, $requestBody);

        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Webhook/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $webhook = new Webhook($appSecret, $verifyToken, $client, $request);

        $this->assertFalse($webhook->isValidCallback());
    }

    public function testWebhookWithInvalidCallback(): void
    {
        $appSecret = 'app_secret';
        $verifyToken = 'verify_token';
        $pageToken = 'page_token';

        $requestBody = file_get_contents(__DIR__ . '/../../Mocks/Callback/invalid_message.json');
        $requestHeaders = [
            'Content-Type' => 'application/json',
            'X-Hub-Signature' => 'sha1=' . hash_hmac('sha1', $requestBody, $appSecret),
        ];

        $request = new ServerRequest('POST', '/app.php/facebook/webhook', $requestHeaders, $requestBody);

        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Webhook/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $webhook = new Webhook($appSecret, $verifyToken, $client, $request);

        $this->assertSame([], $webhook->getDecodedBody());
    }

    public function tearDown(): void
    {
        unset($this->webhookApi);
    }
}
