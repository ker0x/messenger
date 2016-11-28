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
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/account_linking.json');
        $accountLinking = new AccountLinking('https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($accountLinking));
    }

    public function testDomainWhitelist()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/domain_whitelist.json');
        $domainWhitelist = new DomainWhitelist(['https://petersfancyapparel.com']);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($domainWhitelist));
    }

    public function testGreeting()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/greeting.json');
        $greeting = new Greeting('Timeless apparel for the masses.');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($greeting));
    }

    public function testMenu()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/menu.json');

        $buttons = [
            new Postback('Help', 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP'),
            new Postback('Start a New Order', 'DEVELOPER_DEFINED_PAYLOAD_FOR_START_ORDER'),
            (new WebUrl('Checkout', 'http://petersapparel.parseapp.com/checkout'))->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)->setMessengerExtension(true),
            new WebUrl('View Website', 'http://petersapparel.parseapp.com/'),
        ];

        $menu = new Menu($buttons);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($menu));
    }

    public function testPaymentWithPrivacyUrl()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/payment_privacy.json');

        $payment = new Payment();
        $payment->setPrivacyUrl('https://petersfancyapparel.com/payment_privacy.html');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($payment));
    }

    public function testPaymentWithPublicKey()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/payment_public.json');

        $payment = new Payment();
        $payment->setPublicKey("-----BEGIN PGP PUBLIC KEY BLOCK-----\nVersion: GnuPG v1\n\nmQINBFfId.......N5REigmEEW5t\n=gak9\n-----END PGP PUBLIC KEY BLOCK-----\n");

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($payment));
    }

    public function testPaymentWithAddTester()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/payment_add_tester.json');

        $payment = new Payment();
        $payment->addTester('1178041762247207');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($payment));
    }

    public function testPaymentWithRemoveTester()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ThreadSettings/payment_remove_tester.json');

        $payment = new Payment();
        $payment->removeTester('1178041762247207');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($payment));
    }
}