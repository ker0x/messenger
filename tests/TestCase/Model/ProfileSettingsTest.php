<?php
namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Common\Button\Nested;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\Model\ProfileSettings\Greeting;
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

    public function setUp()
    {
        $this->profileSettings = ProfileSettings::create();
    }

    public function testPersistentMenu()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/persistent_menu.json');
        $persistentMenus= $this->profileSettings->addPersistentMenus([
            PersistentMenu::create()
                ->setComposerInputDisabled(true)
                ->addButtons([
                    Nested::create('My Account', [
                        Postback::create('Pay Bill', 'PAYBILL_PAYLOAD'),
                        Postback::create('History', 'HISTORY_PAYLOAD'),
                        Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'),
                    ]),
                    WebUrl::create('Latest News', 'http://petershats.parseapp.com/hat-news')
                        ->setWebviewHeightRatio('full')
                ]),
            PersistentMenu::create('zh_CN')
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($persistentMenus));
    }

    public function testStartButton()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/get_started.json');
        $startButton = $this->profileSettings->addStartButton('GET_STARTED_PAYLOAD');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($startButton));
    }

    public function testGreeting()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/greeting.json');
        $greetings = $this->profileSettings->addGreetings([
            Greeting::create('Hello!'),
            Greeting::create('Timeless apparel for the masses.', 'en_US'),
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($greetings));
    }

    public function testWhitelistedDomains()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/whitelisted_domains.json');
        $whitelistedDomains = $this->profileSettings->addWhitelistedDomains([
           'https://petersfancyapparel.com'
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($whitelistedDomains));
    }

    public function testAccountLinkingUrl()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/account_linking_url.json');
        $accountLinkingUrl = $this->profileSettings->addAccountLinkingUrl('https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($accountLinkingUrl));
    }

    public function testPaymentSettings()
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

    public function testTargetAudience()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/target_audience.json');
        $targetAudience = $this->profileSettings->addTargetAudience(
            TargetAudience::create('custom', ['US'], ['FR'])
                ->addWhitelistCountry('CA')
                ->addBlacklistCountry('IT')
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($targetAudience));
    }

    public function tearDown()
    {
        unset($this->profileSettings);
    }
}