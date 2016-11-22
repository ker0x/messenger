<?php
namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\ThreadSettings;
use Kerox\Messenger\Model\ThreadSettings\AccountLinking;
use Kerox\Messenger\Model\ThreadSettings\DomainWhitelist;
use Kerox\Messenger\Model\ThreadSettings\Greeting;
use Kerox\Messenger\Model\ThreadSettings\Menu;
use Kerox\Messenger\Model\ThreadSettings\Payment;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ThreadSettingsTest extends AbstractTestCase
{

    public function testInvalidState()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$state must be either new_thread, existing_thread');
        $threadSettings = new ThreadSettings(ThreadSettings::TYPE_CALL_TO_ACTIONS, 'old_thread');
    }

    public function testAccountLinking()
    {
        $accountLinking = new AccountLinking('https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic');

        $this->assertJsonStringEqualsJsonString('{"setting_type":"account_linking","account_linking_url":"https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic"}', json_encode($accountLinking));
    }

    public function testDomainWhitelist()
    {
        $domainWhitelist = new DomainWhitelist(['https://petersfancyapparel.com']);

        $this->assertJsonStringEqualsJsonString('{"setting_type":"domain_whitelisting","whitelisted_domains":["https://petersfancyapparel.com"],"domain_action_type":"add"}', json_encode($domainWhitelist));
    }

    public function testGreeting()
    {
        $greeting = new Greeting('Timeless apparel for the masses.');

        $this->assertJsonStringEqualsJsonString('{"setting_type":"greeting","greeting":{"text":"Timeless apparel for the masses."}}', json_encode($greeting));
    }

    public function testMenu()
    {
        $buttons = [
            new Postback('Help', 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP'),
            new Postback('Start a New Order', 'DEVELOPER_DEFINED_PAYLOAD_FOR_START_ORDER'),
            (new WebUrl('Checkout', 'http://petersapparel.parseapp.com/checkout'))->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)->setMessengerExtension(true),
            new WebUrl('View Website', 'http://petersapparel.parseapp.com/'),
        ];

        $menu = new Menu($buttons);

        $this->assertJsonStringEqualsJsonString('{"setting_type":"call_to_actions","thread_state":"existing_thread","call_to_actions":[{"type":"postback","title":"Help","payload":"DEVELOPER_DEFINED_PAYLOAD_FOR_HELP"},{"type":"postback","title":"Start a New Order","payload":"DEVELOPER_DEFINED_PAYLOAD_FOR_START_ORDER"},{"type":"web_url","title":"Checkout","url":"http://petersapparel.parseapp.com/checkout","webview_height_ratio":"full","messenger_extensions":true},{"type":"web_url","title":"View Website","url":"http://petersapparel.parseapp.com/"}]}', json_encode($menu));
    }

    public function testPaymentWithPrivacyUrl()
    {
        $payment = new Payment();
        $payment->setPrivacyUrl('https://petersfancyapparel.com/payment_privacy.html');

        $this->assertJsonStringEqualsJsonString('{"setting_type":"payment","payment_privacy_url":"https://petersfancyapparel.com/payment_privacy.html"}', json_encode($payment));
    }

    public function testPaymentWithPublicKey()
    {
        $payment = new Payment();
        $payment->setPublicKey("-----BEGIN PGP PUBLIC KEY BLOCK-----\nVersion: GnuPG v1\n\nmQINBFfId.......N5REigmEEW5t\n=gak9\n-----END PGP PUBLIC KEY BLOCK-----\n");

        $this->assertJsonStringEqualsJsonString('{"setting_type":"payment","payment_public_key":"-----BEGIN PGP PUBLIC KEY BLOCK-----\nVersion: GnuPG v1\n\nmQINBFfId.......N5REigmEEW5t\n=gak9\n-----END PGP PUBLIC KEY BLOCK-----\n"}', json_encode($payment));
    }

    public function testPaymentWithAddTester()
    {
        $payment = new Payment();
        $payment->addTester('1178041762247207');

        $this->assertJsonStringEqualsJsonString('{"setting_type":"payment","payment_dev_mode_action":"ADD","payment_testers":["1178041762247207"]}', json_encode($payment));
    }

    public function testPaymentWithRemoveTester()
    {
        $payment = new Payment();
        $payment->removeTester('1178041762247207');

        $this->assertJsonStringEqualsJsonString('{"setting_type":"payment","payment_dev_mode_action":"REMOVE","payment_testers":["1178041762247207"]}', json_encode($payment));
    }
}