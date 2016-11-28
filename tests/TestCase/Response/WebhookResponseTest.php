<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\WebhookResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class WebhookResponseTest extends AbstractTestCase
{

    public function testWebhookResponse()
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/WebhookResponse/success.json');

        $response = new Response(200, [], $body);
        $webhookResponse = new WebhookResponse($response);

        $this->assertTrue($webhookResponse->isSuccess());
    }
}