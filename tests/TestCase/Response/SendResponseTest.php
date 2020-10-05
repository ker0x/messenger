<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\SendResponse;
use PHPUnit\Framework\TestCase;

class SendResponseTest extends TestCase
{
    public function testResponse(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/basic.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        self::assertSame('1008372609250235', $sendResponse->getRecipientId());
        self::assertSame('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        self::assertNull($sendResponse->getAttachmentId());
        self::assertNull($sendResponse->getErrorMessage());
        self::assertNull($sendResponse->getErrorType());
        self::assertNull($sendResponse->getErrorCode());
        self::assertNull($sendResponse->getErrorSubcode());
        self::assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithAttachmentId(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/attachment_to_user.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        self::assertSame('1008372609250235', $sendResponse->getRecipientId());
        self::assertSame('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        self::assertSame('1745504518999123', $sendResponse->getAttachmentId());
        self::assertNull($sendResponse->getErrorMessage());
        self::assertNull($sendResponse->getErrorType());
        self::assertNull($sendResponse->getErrorCode());
        self::assertNull($sendResponse->getErrorSubcode());
        self::assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithError(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/error.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        self::assertNull($sendResponse->getRecipientId());
        self::assertNull($sendResponse->getMessageId());
        self::assertNull($sendResponse->getAttachmentId());
        self::assertSame('Invalid OAuth access token.', $sendResponse->getErrorMessage());
        self::assertSame('OAuthException', $sendResponse->getErrorType());
        self::assertSame(190, $sendResponse->getErrorCode());
        self::assertSame(1234567, $sendResponse->getErrorSubcode());
        self::assertSame('BLBz/WZt8dN', $sendResponse->getErrorFbtraceId());
    }

    public function testRawResponse(): void
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/basic.json');

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        self::assertSame(200, $sendResponse->getResponse()->getStatusCode());
        self::assertSame($body, $sendResponse->getResponse()->getBody()->__toString());
    }
}
