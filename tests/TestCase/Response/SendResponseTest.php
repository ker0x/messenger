<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class SendResponseTest extends AbstractTestCase
{

    public function testResponse()
    {
        $body = '{
          "recipient_id": "1008372609250235",
          "message_id": "mid.1456970487936:c34767dfe57ee6e339"
        }';

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertEquals('1008372609250235', $sendResponse->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        $this->assertNull($sendResponse->getAttachmentId());
        $this->assertNull($sendResponse->getErrorMessage());
        $this->assertNull($sendResponse->getErrorType());
        $this->assertNull($sendResponse->getErrorCode());
        $this->assertNull($sendResponse->getErrorSubcode());
        $this->assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithAttachmentId()
    {
        $body = '{
          "recipient_id": "1008372609250235",
          "message_id": "mid.1456970487936:c34767dfe57ee6e339",
          "attachment_id": "1745504518999123"
        }';

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertEquals('1008372609250235', $sendResponse->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $sendResponse->getMessageId());
        $this->assertEquals('1745504518999123', $sendResponse->getAttachmentId());
        $this->assertNull($sendResponse->getErrorMessage());
        $this->assertNull($sendResponse->getErrorType());
        $this->assertNull($sendResponse->getErrorCode());
        $this->assertNull($sendResponse->getErrorSubcode());
        $this->assertNull($sendResponse->getErrorFbtraceId());
    }

    public function testResponseWithError()
    {
        $body = '{
          "error": {
            "message": "Invalid OAuth access token.",
            "type": "OAuthException",
            "code": 190,
            "error_subcode": 1234567,
            "fbtrace_id": "BLBz/WZt8dN"
          }
        }';

        $response = new Response(200, [], $body);
        $sendResponse = new SendResponse($response);

        $this->assertNull($sendResponse->getRecipientId());
        $this->assertNull($sendResponse->getMessageId());
        $this->assertNull($sendResponse->getAttachmentId());
        $this->assertEquals('Invalid OAuth access token.', $sendResponse->getErrorMessage());
        $this->assertEquals('OAuthException', $sendResponse->getErrorType());
        $this->assertEquals(190, $sendResponse->getErrorCode());
        $this->assertEquals(1234567, $sendResponse->getErrorSubcode());
        $this->assertEquals('BLBz/WZt8dN', $sendResponse->getErrorFbtraceId());
    }
}