<?php
namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Response\UserResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class UserTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\User
     */
    protected $userApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/User/user.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->userApi = new User('abcd1234', $client);
    }

    public function testGetProfile()
    {
        $response = $this->userApi->profile('1234abcd');

        $this->assertInstanceOf(UserResponse::class, $response);
    }

    public function testGetProfileWithBadField()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('username is not a valid value. $fields must only contain first_name, last_name, profile_pic, locale, timezone, gender, is_payment_enabled');
        $response = $this->userApi->profile('1234abcd', ['username']);
    }
}