<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Common\Button;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\Payment\PaymentSummary;
use Kerox\Messenger\Model\Common\Button\Payment\PriceList;
use PHPUnit\Framework\TestCase;

class PaymentSummaryTest extends TestCase
{
    public function testPaymentType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('paymentType must be either "FIXED_AMOUNT, FLEXIBLE_AMOUNT".');

        $requestedUserInfo = [
            PaymentSummary::USER_INFO_SHIPPING_ADDRESS,
            PaymentSummary::USER_INFO_CONTACT_NAME,
            PaymentSummary::USER_INFO_CONTACT_PHONE,
            PaymentSummary::USER_INFO_CONTACT_EMAIL,
        ];

        $priceList = [
            PriceList::create('Subtotal', '29.99'),
            PriceList::create('Taxes', '2.47'),
        ];

        PaymentSummary::create(
            'USD',
            'MOVING_AMOUNT',
            'Peter\'s Apparel',
            $requestedUserInfo,
            $priceList
        );
    }

    public function testRequestedUserInfo(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('billing_address is not a valid value. Valid values are "shipping_address, contact_name, contact_phone, contact_email".');

        $priceList = [
            PriceList::create('Subtotal', '29.99'),
            PriceList::create('Taxes', '2.47'),
        ];

        PaymentSummary::create(
            'USD',
            PaymentSummary::PAYMENT_TYPE_FIXED_AMOUNT,
            'Peter\'s Apparel',
            ['billing_address'],
            $priceList
        );
    }
}
