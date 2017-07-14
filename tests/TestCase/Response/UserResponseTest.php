<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Model\Referral;
use Kerox\Messenger\Response\UserResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class UserResponseTest extends AbstractTestCase
{

    public function testUserResponse()
    {
        $body = file_get_contents(__DIR__ . '/../../Mocks/Response/User/user.json');

        $response = new Response(200, [], $body);
        $userResponse = new UserResponse($response);

        $this->assertEquals('Peter', $userResponse->getFirstName());
        $this->assertEquals('Chang', $userResponse->getLastName());
        $this->assertEquals('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce', $userResponse->getProfilePic());
        $this->assertEquals('en_US', $userResponse->getLocale());
        $this->assertEquals(-7, $userResponse->getTimezone());
        $this->assertEquals('male', $userResponse->getGender());
        $this->assertTrue($userResponse->isPaymentEnabled());
        $this->assertInstanceOf(Referral::class, $userResponse->getLastAdReferral());
        $this->assertEquals('ADS', $userResponse->getLastAdReferral()->getSource());
        $this->assertEquals('OPEN_THREAD', $userResponse->getLastAdReferral()->getType());
        $this->assertEquals('6045246247433', $userResponse->getLastAdReferral()->getAdId());
        $this->assertEquals('myparam', $userResponse->getLastAdReferral()->getRef());
    }
}