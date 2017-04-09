<?php
namespace Kerox\Messenger\Test\TestCase\Model\Common\Buttons;

use Kerox\Messenger\Model\Common\Buttons\Payment\PaymentSummary;
use Kerox\Messenger\Model\Common\Buttons\Payment\PriceList;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PaymentSummaryTest extends AbstractTestCase
{

    public function testPaymentType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$paymentType must be either FIXED_AMOUNT, FLEXIBLE_AMOUNT');

        $requestedUserInfo = [
            PaymentSummary::USER_INFO_SHIPPING_ADDRESS,
            PaymentSummary::USER_INFO_CONTACT_NAME,
            PaymentSummary::USER_INFO_CONTACT_PHONE,
            PaymentSummary::USER_INFO_CONTACT_EMAIL,
        ];

        $priceList = [
            new PriceList('Subtotal', '29.99'),
            new PriceList('Taxes', '2.47'),
        ];

        $paymentSummary = new PaymentSummary(
            'USD',
            'MOVING_AMOUNT',
            'Peter\'s Apparel',
            $requestedUserInfo,
            $priceList
        );
    }
}