<?php
namespace Kerox\Messenger\Test\TestCase\Message\Attachment\Template;

use Kerox\Messenger\Message\Attachment\Template\Buttons\AccountLink;
use Kerox\Messenger\Message\Attachment\Template\Buttons\AccountUnlink;
use Kerox\Messenger\Message\Attachment\Template\Buttons\Payment;
use Kerox\Messenger\Message\Attachment\Template\Buttons\Payment\PaymentSummary;
use Kerox\Messenger\Message\Attachment\Template\Buttons\Payment\PriceList;
use Kerox\Messenger\Message\Attachment\Template\Buttons\PhoneNumber;
use Kerox\Messenger\Message\Attachment\Template\Buttons\Postback;
use Kerox\Messenger\Message\Attachment\Template\Buttons\Share;
use Kerox\Messenger\Message\Attachment\Template\Buttons\WebUrl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ButtonTest extends AbstractTestCase
{

    public function testButtonAccountLink()
    {
        $buttonAccountLink = new AccountLink('https://www.example.com/authorize');

        $this->assertJsonStringEqualsJsonString('{"type": "account_link","url": "https://www.example.com/authorize"}', json_encode($buttonAccountLink));
    }

    public function testButtonAccountUnlink()
    {
        $buttonAccountUnlink = new AccountUnlink();

        $this->assertJsonStringEqualsJsonString('{"type": "account_unlink"}', json_encode($buttonAccountUnlink));
    }

    public function testButtonPayment()
    {
        $paymentSummary = new PaymentSummary(
            'USD',
            PaymentSummary::PAYMENT_TYPE_FIXED_AMOUNT,
            'Peter\'s Apparel',
            [
                PaymentSummary::USER_INFO_SHIPPING_ADDRESS,
                PaymentSummary::USER_INFO_CONTACT_NAME,
                PaymentSummary::USER_INFO_CONTACT_PHONE,
                PaymentSummary::USER_INFO_CONTACT_EMAIL,
            ],
            [
                new PriceList('Subtotal', '29.99'),
                new PriceList('Taxes', '2.47'),
            ]
        );
        $paymentSummary->isTestPayment(true);
        $buttonPayment = new Payment('DEVELOPER_DEFINED_PAYLOAD', $paymentSummary);

        $this->assertJsonStringEqualsJsonString('{"type":"payment","title":"buy","payload":"DEVELOPER_DEFINED_PAYLOAD","payment_summary":{"currency":"USD","payment_type":"FIXED_AMOUNT","is_test_payment":true,"merchant_name":"Peter\'s Apparel","requested_user_info":["shipping_address","contact_name","contact_phone","contact_email"],"price_list":[{"label":"Subtotal","amount":"29.99"},{"label":"Taxes","amount":"2.47"}]}}', json_encode($buttonPayment));
    }

    public function testButtonPhoneNumber()
    {
        $buttonPhoneNumber = new PhoneNumber('Call Representative', '+15105551234');

        $this->assertJsonStringEqualsJsonString('{"type":"phone_number","title":"Call Representative","payload":"+15105551234"}', json_encode($buttonPhoneNumber));
    }

    public function testButtonPostback()
    {
        $buttonPostback = new Postback('Bookmark Item', 'DEVELOPER_DEFINED_PAYLOAD');

        $this->assertJsonStringEqualsJsonString('{"type":"postback","title":"Bookmark Item","payload":"DEVELOPER_DEFINED_PAYLOAD"}', json_encode($buttonPostback));
    }

    public function testButtonShare()
    {
        $buttonShare = new Share();

        $this->assertJsonStringEqualsJsonString('{"type":"element_share"}', json_encode($buttonShare));
    }

    public function testButtonWebUrl()
    {
        $buttonWebUrl = new WebUrl('Select Criteria', 'https://petersfancyapparel.com/criteria_selector');
        $buttonWebUrl
            ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)
            ->setMessengerExtension(true)
            ->setFallbackUrl('https://petersfancyapparel.com/fallback');

        $this->assertJsonStringEqualsJsonString('{"type":"web_url","url":"https://petersfancyapparel.com/criteria_selector","title":"Select Criteria","webview_height_ratio": "full","messenger_extensions": true,"fallback_url":"https://petersfancyapparel.com/fallback"}', json_encode($buttonWebUrl));
    }
}