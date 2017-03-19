<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\ProfileResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ProfileResponseTest extends AbstractTestCase
{

    public function testAddProfileResponse()
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/Profile/add.json');

        $response = new Response(200, [], $body);
        $profileResponse = new ProfileResponse($response);

        $this->assertEquals('success', $profileResponse->getResult());
    }
}