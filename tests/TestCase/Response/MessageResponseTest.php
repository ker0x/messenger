<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\MessageResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageResponseTest extends AbstractTestCase
{

    public function testResponse()
    {
        $body = '{
          "recipient_id": "1008372609250235",
          "message_id": "mid.1456970487936:c34767dfe57ee6e339"
        }';

        $response = new Response(200, [], $body);
        $messageResponse = new MessageResponse($response);

        $this->assertEquals('1008372609250235', $messageResponse->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $messageResponse->getMessageId());
        $this->assertNull($messageResponse->getAttachmentId());
        $this->assertNull($messageResponse->getErrorMessage());
        $this->assertNull($messageResponse->getErrorType());
        $this->assertNull($messageResponse->getErrorCode());
        $this->assertNull($messageResponse->getErrorSubcode());
        $this->assertNull($messageResponse->getErrorFbtraceId());
    }

    public function testResponseWithAttachmentId()
    {
        $body = '{
          "recipient_id": "1008372609250235",
          "message_id": "mid.1456970487936:c34767dfe57ee6e339",
          "attachment_id": "1745504518999123"
        }';

        $response = new Response(200, [], $body);
        $messageResponse = new MessageResponse($response);

        $this->assertEquals('1008372609250235', $messageResponse->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $messageResponse->getMessageId());
        $this->assertEquals('1745504518999123', $messageResponse->getAttachmentId());
        $this->assertNull($messageResponse->getErrorMessage());
        $this->assertNull($messageResponse->getErrorType());
        $this->assertNull($messageResponse->getErrorCode());
        $this->assertNull($messageResponse->getErrorSubcode());
        $this->assertNull($messageResponse->getErrorFbtraceId());
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
        $messageResponse = new MessageResponse($response);

        $this->assertNull($messageResponse->getRecipientId());
        $this->assertNull($messageResponse->getMessageId());
        $this->assertNull($messageResponse->getAttachmentId());
        $this->assertEquals('Invalid OAuth access token.', $messageResponse->getErrorMessage());
        $this->assertEquals('OAuthException', $messageResponse->getErrorType());
        $this->assertEquals(190, $messageResponse->getErrorCode());
        $this->assertEquals(1234567, $messageResponse->getErrorSubcode());
        $this->assertEquals('BLBz/WZt8dN', $messageResponse->getErrorFbtraceId());
    }
}