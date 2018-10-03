<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class SendResponseTest extends AbstractTestCase
{
    public function testResponse(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/basic.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertSame('1008372609250235', $sendResponse->getRecipientId());
        $this->assertSame('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        $this->assertNull($sendResponse->getAttachmentId());
        $this->assertNull($sendResponse->getErrorMessage());
        $this->assertNull($sendResponse->getErrorType());
        $this->assertNull($sendResponse->getErrorCode());
        $this->assertNull($sendResponse->getErrorSubcode());
        $this->assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithAttachmentId(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/attachment_to_user.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertSame('1008372609250235', $sendResponse->getRecipientId());
        $this->assertSame('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        $this->assertSame('1745504518999123', $sendResponse->getAttachmentId());
        $this->assertNull($sendResponse->getErrorMessage());
        $this->assertNull($sendResponse->getErrorType());
        $this->assertNull($sendResponse->getErrorCode());
        $this->assertNull($sendResponse->getErrorSubcode());
        $this->assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithError(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/error.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertNull($sendResponse->getRecipientId());
        $this->assertNull($sendResponse->getMessageId());
        $this->assertNull($sendResponse->getAttachmentId());
        $this->assertSame('Invalid OAuth access token.', $sendResponse->getErrorMessage());
        $this->assertSame('OAuthException', $sendResponse->getErrorType());
        $this->assertSame(190, $sendResponse->getErrorCode());
        $this->assertSame(1234567, $sendResponse->getErrorSubcode());
        $this->assertSame('BLBz/WZt8dN', $sendResponse->getErrorFbtraceId());
    }

    public function testRawResponse(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/basic.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertSame(200, $sendResponse->getResponse()->getStatusCode());
        $this->assertSame($body, $sendResponse->getResponse()->getBody()->__toString());
    }
}
