<?php
namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Common\Buttons\Nested;
use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
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
        $this->profileSettings = new ProfileSettings();
    }

    public function testPersistentMenu()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/persistent_menu.json');
        $persistentMenu = $this->profileSettings->addPersistentMenus([
            (new PersistentMenu())->setComposerInputDisabled(true)->addButtons([
                (new Nested('My Account', [
                    new Postback('Pay Bill', 'PAYBILL_PAYLOAD'),
                    new Postback('History', 'HISTORY_PAYLOAD'),
                    new Postback('Contact Info', 'CONTACT_INFO_PAYLOAD'),
                ])),
                (new WebUrl('Latest News', 'http://petershats.parseapp.com/hat-news'))->setWebviewHeightRatio('full')
            ]),
            (new PersistentMenu('zh_CN'))
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($persistentMenu));
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
            new Greeting('Hello!'),
            new Greeting('Timeless apparel for the masses.', 'en_US'),
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
            (new PaymentSettings())
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
            (new TargetAudience('custom', ['US'], ['FR']))
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