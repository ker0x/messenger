<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\Payment\PaymentCredential;
use Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PaymentTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\Payment
     */
    protected $payment;

    public function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/payment.json');
        $array = json_decode($json, true);

        $this->payment = Payment::create($array['payment']);
    }

    public function testPaymentCallback(): void
    {
        $this->assertSame('DEVELOPER_DEFINED_PAYLOAD', $this->payment->getPayload());
        $this->assertSame('123', $this->payment->getShippingOptionId());
        $this->assertSame('USD', $this->payment->getCurrency());
        $this->assertSame('29.62', $this->payment->getAmount());
        $this->assertInstanceOf(RequestedUserInfo::class, $this->payment->getRequestedUserInfo());
        $this->assertInstanceOf(PaymentCredential::class, $this->payment->getPaymentCredential());
        $this->assertInstanceOf(Address::class, $this->payment->getShippingAddress());
    }

    public function testPaymentRequestedUserInfo(): void
    {
        $requestedUserInfo = $this->payment->getRequestedUserInfo();

        $this->assertSame('Peter Chang', $requestedUserInfo->getContactName());
        $this->assertSame('peter@anemailprovider.com', $requestedUserInfo->getContactEmail());
        $this->assertSame('+15105551234', $requestedUserInfo->getContactPhone());
    }

    public function testPaymentCredential(): void
    {
        $paymentCredential = $this->payment->getPaymentCredential();

        $this->assertSame('token', $paymentCredential->getProviderType());
        $this->assertSame('ch_18tmdBEoNIH3FPJHa60ep123', $paymentCredential->getChargeId());
        $this->assertSame('__tokenized_card__', $paymentCredential->getTokenizedCard());
        $this->assertSame('tokenized cvv', $paymentCredential->getTokenizedCvv());
        $this->assertSame('3', $paymentCredential->getTokenExpiryMonth());
        $this->assertSame('2019', $paymentCredential->getTokenExpiryYear());
        $this->assertSame('123456789', $paymentCredential->getFbPaymentId());
    }

    public function testPaymentShippingAddress(): void
    {
        $shippingAddress = $this->payment->getShippingAddress();

        $this->assertSame('1 Hacker Way', $shippingAddress->getStreet());
        $this->assertSame('', $shippingAddress->getAdditionalStreet());
        $this->assertSame('MENLO PARK', $shippingAddress->getCity());
        $this->assertSame('CA', $shippingAddress->getState());
        $this->assertSame('US', $shippingAddress->getCountry());
        $this->assertSame('94025', $shippingAddress->getPostalCode());
    }

    public function tearDown(): void
    {
        unset($this->payment);
    }
}
