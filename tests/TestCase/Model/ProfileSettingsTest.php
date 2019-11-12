<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Common\Button\Nested;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\Model\ProfileSettings\Greeting;
use Kerox\Messenger\Model\ProfileSettings\HomeUrl;
use Kerox\Messenger\Model\ProfileSettings\IceBreakers;
use Kerox\Messenger\Model\ProfileSettings\PaymentSettings;
use Kerox\Messenger\Model\ProfileSettings\PersistentMenu;
use Kerox\Messenger\Model\ProfileSettings\TargetAudience;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ProfileSettingsTest extends AbstractTestCase
{
    /**
     * @var ProfileSettings
     */
    protected $profileSettings;

    public function setUp(): void
    {
        $this->profileSettings = ProfileSettings::create();
    }

    public function testPersistentMenu(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/persistent_menu.json');
        $persistentMenus = $this->profileSettings->addPersistentMenus([
            PersistentMenu::create()
                ->setComposerInputDisabled(true)
                ->addButtons([
                    Nested::create('My Account', [
                        Postback::create('Pay Bill', 'PAYBILL_PAYLOAD'),
                        Postback::create('History', 'HISTORY_PAYLOAD'),
                        Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'),
                    ]),
                    WebUrl::create('Latest News', 'http://petershats.parseapp.com/hat-news')
                        ->setWebviewHeightRatio('full'),
                ]),
            PersistentMenu::create('zh_CN'),
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($persistentMenus));
    }

    public function testStartButton(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/get_started.json');
        $startButton = $this->profileSettings->addStartButton('GET_STARTED_PAYLOAD');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($startButton));
    }

    public function testGreeting(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/greeting.json');
        $greetings = $this->profileSettings->addGreetings([
            Greeting::create('Hello!'),
            Greeting::create('Timeless apparel for the masses.', 'en_US'),
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($greetings));
    }

    public function testIceBreakers(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/ice_breakers.json');
        $iceBreakers = $this->profileSettings->addIceBreakers([
            IceBreakers::create('Where are you located?', 'LOCATION_POSTBACK_PAYLOAD'),
            IceBreakers::create('What are your hours?', 'HOURS_POSTBACK_PAYLOAD'),
            IceBreakers::create('Can you tell me more about your business?', 'MORE_POSTBACK_PAYLOAD'),
            IceBreakers::create('What services do you offer?', 'SERVICES_POSTBACK_PAYLOAD'),
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($iceBreakers));
    }

    public function testWhitelistedDomains(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/whitelisted_domains.json');
        $whitelistedDomains = $this->profileSettings->addWhitelistedDomains([
            'https://petersfancyapparel.com',
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($whitelistedDomains));
    }

    public function testAccountLinkingUrl(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/account_linking_url.json');
        $accountLinkingUrl = $this->profileSettings->addAccountLinkingUrl('https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($accountLinkingUrl));
    }

    public function testPaymentSettings(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/payment_settings.json');
        $paymentSettings = $this->profileSettings->addPaymentSettings(
            PaymentSettings::create()
                ->setPrivacyUrl('http://www.facebook.com')
                ->setPublicKey('YOUR_PUBLIC_KEY')
                ->addTestUser(12345678)
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($paymentSettings));
    }

    public function testHomeUrl(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/home_url.json');
        $homeUrl = $this->profileSettings->addHomeUrl(HomeUrl::create(
            'https://chat.example.com',
            'tall',
            'show'
        ));

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($homeUrl));
    }

    public function testTargetAudience(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/target_audience.json');
        $targetAudience = $this->profileSettings->addTargetAudience(
            TargetAudience::create('custom', ['US'], ['FR'])
                ->addWhitelistCountry('CA')
                ->addBlacklistCountry('IT')
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($targetAudience));
    }

    public function tearDown(): void
    {
        unset($this->profileSettings);
    }
}
