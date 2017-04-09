<?php
namespace Kerox\Messenger\Test\TestCase\Model\Common;

use Kerox\Messenger\Model\Common\Buttons\AccountLink;
use Kerox\Messenger\Model\Common\Buttons\AccountUnlink;
use Kerox\Messenger\Model\Common\Buttons\Nested;
use Kerox\Messenger\Model\Common\Buttons\Payment;
use Kerox\Messenger\Model\Common\Buttons\Payment\PaymentSummary;
use Kerox\Messenger\Model\Common\Buttons\Payment\PriceList;
use Kerox\Messenger\Model\Common\Buttons\PhoneNumber;
use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\Share;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Generic;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ButtonTest extends AbstractTestCase
{

    public function testButtonAccountLink()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/account_link.json');

        $buttonAccountLink = new AccountLink('https://www.example.com/authorize');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonAccountLink));
    }

    public function testButtonAccountUnlink()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/account_unlink.json');

        $buttonAccountUnlink = new AccountUnlink();

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonAccountUnlink));
    }

    public function testButtonPayment()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/payment.json');

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
        $paymentSummary
            ->isTestPayment(true)
            ->addPriceList('Shipment', '3');

        $buttonPayment = new Payment('DEVELOPER_DEFINED_PAYLOAD', $paymentSummary);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPayment));
    }

    public function testButtonPhoneNumber()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/phone_number.json');

        $buttonPhoneNumber = new PhoneNumber('Call Representative', '+15105551234');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPhoneNumber));
    }

    public function testButtonPostback()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/postback.json');

        $buttonPostback = new Postback('Bookmark Item', 'DEVELOPER_DEFINED_PAYLOAD');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPostback));
    }

    public function testButtonShare()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/share.json');

        $generic = new Generic([
            (new GenericElement('I took Peter\'s \'Which Hat Are You?\' Quiz'))
                ->setSubtitle('My result: Fez')
                ->setImageUrl('https://bot.peters-hats.com/img/hats/fez.jpg')
                ->setDefaultAction(new WebUrl('', 'http://m.me/petershats?ref=invited_by_24601'))
                ->setButtons([
                    new WebUrl('Take Quiz', 'http://m.me/petershats?ref=invited_by_24601'),
                ])
        ]);

        $buttonShare = new Share($generic);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonShare));
    }

    public function testButtonWebUrl()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/weburl.json');

        $buttonWebUrl = new WebUrl('Select Criteria', 'https://petersfancyapparel.com/criteria_selector');
        $buttonWebUrl
            ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)
            ->setMessengerExtension(true)
            ->setFallbackUrl('https://petersfancyapparel.com/fallback')
            ->setWebviewShareButton(false);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonWebUrl));
    }

    public function testButtonNested()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/nested.json');

        $buttonNested = new Nested('My Account', [new Postback('Pay Bill', 'PAYBILL_PAYLOAD')]);
        $buttonNested
            ->addButton(new Postback('History', 'HISTORY_PAYLOAD'))
            ->addButton(new Postback('Contact Info', 'CONTACT_INFO_PAYLOAD'));

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonNested));
    }
}