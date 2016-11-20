<?php
namespace Kerox\Messenger\Test\TestCase\Response;

use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Response\UserProfileResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class UserProfileResponseTest extends AbstractTestCase
{

    public function testUserProfileResponse()
    {
        $body = '{
          "first_name": "Peter",
          "last_name": "Chang",
          "profile_pic": "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce",
          "locale": "en_US",
          "timezone": -7,
          "gender": "male"
        }';

        $response = new Response(200, [], $body);
        $userProfileResponse = new UserProfileResponse($response);

        $this->assertEquals('Peter', $userProfileResponse->getFirstName());
        $this->assertEquals('Chang', $userProfileResponse->getLastName());
        $this->assertEquals('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce', $userProfileResponse->getProfilePic());
        $this->assertEquals('en_US', $userProfileResponse->getLocale());
        $this->assertEquals(-7, $userProfileResponse->getTimezone());
        $this->assertEquals('male', $userProfileResponse->getGender());
        $this->assertNull($userProfileResponse->getIsPaymentEnabled());
    }
}