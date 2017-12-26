<?php
namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Model\Referral;
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
        $this->assertEquals('Peter', $response->getFirstName());
        $this->assertEquals('Chang', $response->getLastName());
        $this->assertEquals('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce', $response->getProfilePic());
        $this->assertEquals('en_US', $response->getLocale());
        $this->assertEquals(-7, $response->getTimezone());
        $this->assertEquals('male', $response->getGender());
        $this->assertTrue($response->isPaymentEnabled());
        $this->assertInstanceOf(Referral::class, $response->getLastAdReferral());
        $this->assertEquals('ADS', $response->getLastAdReferral()->getSource());
        $this->assertEquals('OPEN_THREAD', $response->getLastAdReferral()->getType());
        $this->assertEquals('6045246247433', $response->getLastAdReferral()->getAdId());
        $this->assertEquals('myparam', $response->getLastAdReferral()->getRef());
    }

    public function testGetProfileWithBadField()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('username is not a valid value. $fields must only contain first_name, last_name, profile_pic, locale, timezone, gender, is_payment_enabled');
        $response = $this->userApi->profile('1234abcd', ['username']);
    }
}