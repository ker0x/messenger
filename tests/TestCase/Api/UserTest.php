<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use Kerox\Messenger\Api\User;
use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Referral;
use Kerox\Messenger\Test\TestCase\ResourceTestCase;

/**
 * Class UserTest
 *
 * @property User $resource
 */
class UserTest extends ResourceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/User/user.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new User($this->client);
    }

    public function testGetProfile(): void
    {
        $response = $this->resource->profile('1234abcd');

        $this->assertSame('Peter', $response->getFirstName());
        $this->assertSame('Chang', $response->getLastName());
        $this->assertSame('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce', $response->getProfilePic());
        $this->assertSame('en_US', $response->getLocale());
        $this->assertSame(-7., $response->getTimezone());
        $this->assertSame('male', $response->getGender());
        $this->assertTrue($response->isPaymentEnabled());
        $this->assertInstanceOf(Referral::class, $response->getLastAdReferral());
        $this->assertSame('ADS', $response->getLastAdReferral()->getSource());
        $this->assertSame('OPEN_THREAD', $response->getLastAdReferral()->getType());
        $this->assertSame('6045246247433', $response->getLastAdReferral()->getAdId());
        $this->assertSame('myparam', $response->getLastAdReferral()->getRef());
    }

    public function testGetProfileWithBadField(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('username is not a valid value. fields must only contain "first_name, last_name, profile_pic, locale, timezone, gender, is_payment_enabled".');

        $this->resource->profile('1234abcd', ['username']);
    }
}
