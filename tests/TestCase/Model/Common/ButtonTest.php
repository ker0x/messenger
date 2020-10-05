<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Common;

use Kerox\Messenger\Model\Common\Button\AccountLink;
use Kerox\Messenger\Model\Common\Button\AccountUnlink;
use Kerox\Messenger\Model\Common\Button\Nested;
use Kerox\Messenger\Model\Common\Button\Payment;
use Kerox\Messenger\Model\Common\Button\Payment\PaymentSummary;
use Kerox\Messenger\Model\Common\Button\Payment\PriceList;
use Kerox\Messenger\Model\Common\Button\PhoneNumber;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\Share;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;
use PHPUnit\Framework\TestCase;

class ButtonTest extends TestCase
{
    public function testButtonAccountLink(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/account_link.json');

        $buttonAccountLink = AccountLink::create('https://www.example.com/authorize');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonAccountLink, JSON_THROW_ON_ERROR));
    }

    public function testButtonAccountUnlink(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/account_unlink.json');

        $buttonAccountUnlink = AccountUnlink::create();

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonAccountUnlink, JSON_THROW_ON_ERROR));
    }

    public function testButtonPayment(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/payment.json');

        $paymentSummary = PaymentSummary::create(
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
                PriceList::create('Subtotal', '29.99'),
                PriceList::create('Taxes', '2.47'),
            ]
        )->isTestPayment(true)->addPriceList('Shipment', '3');

        $buttonPayment = Payment::create('DEVELOPER_DEFINED_PAYLOAD', $paymentSummary);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPayment, JSON_THROW_ON_ERROR));
    }

    public function testButtonPhoneNumber(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/phone_number.json');

        $buttonPhoneNumber = PhoneNumber::create('Call Representative', '+15105551234');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPhoneNumber, JSON_THROW_ON_ERROR));
    }

    public function testButtonPostback(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/postback.json');

        $buttonPostback = Postback::create('Bookmark Item', 'DEVELOPER_DEFINED_PAYLOAD');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonPostback, JSON_THROW_ON_ERROR));
    }

    public function testButtonShare(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/share.json');

        $generic = GenericTemplate::create([
            GenericElement::create('I took Peter\'s \'Which Hat Are You?\' Quiz')
                ->setSubtitle('My result: Fez')
                ->setImageUrl('https://bot.peters-hats.com/img/hats/fez.jpg')
                ->setDefaultAction(new WebUrl('', 'http://m.me/petershats?ref=invited_by_24601'))
                ->setButtons([
                    WebUrl::create('Take Quiz', 'http://m.me/petershats?ref=invited_by_24601'),
                ]),
        ]);

        $buttonShare = Share::create($generic);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonShare, JSON_THROW_ON_ERROR));
    }

    public function testButtonWebUrl(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/weburl.json');

        $buttonWebUrl = WebUrl::create('Select Criteria', 'https://petersfancyapparel.com/criteria_selector')
            ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)
            ->setMessengerExtension(true)
            ->setFallbackUrl('https://petersfancyapparel.com/fallback')
            ->setWebviewShareButton(false);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonWebUrl, JSON_THROW_ON_ERROR));
    }

    public function testButtonNested(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Button/nested.json');

        $buttonNested = Nested::create('My Account', [new Postback('Pay Bill', 'PAYBILL_PAYLOAD')])
            ->addButton(Postback::create('History', 'HISTORY_PAYLOAD'))
            ->addButton(Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'));

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($buttonNested, JSON_THROW_ON_ERROR));
    }
}
