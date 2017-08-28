<?php
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

    public function setUp()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/payment.json');
        $array = json_decode($json, true);

        $this->payment = Payment::create($array['payment']);
    }

    public function testPaymentCallback()
    {
        $this->assertEquals('DEVELOPER_DEFINED_PAYLOAD', $this->payment->getPayload());
        $this->assertEquals('123', $this->payment->getShippingOptionId());
        $this->assertEquals('USD', $this->payment->getCurrency());
        $this->assertEquals('29.62', $this->payment->getAmount());
        $this->assertInstanceOf(RequestedUserInfo::class, $this->payment->getRequestedUserInfo());
        $this->assertInstanceOf(PaymentCredential::class, $this->payment->getPaymentCredential());
        $this->assertInstanceOf(Address::class, $this->payment->getShippingAddress());
    }

    public function testPaymentRequestedUserInfo()
    {
        $requestedUserInfo = $this->payment->getRequestedUserInfo();

        $this->assertEquals('Peter Chang', $requestedUserInfo->getContactName());
        $this->assertEquals('peter@anemailprovider.com', $requestedUserInfo->getContactEmail());
        $this->assertEquals('+15105551234', $requestedUserInfo->getContactPhone());
    }

    public function testPaymentCredential()
    {
        $paymentCredential = $this->payment->getPaymentCredential();

        $this->assertEquals('token', $paymentCredential->getProviderType());
        $this->assertEquals('ch_18tmdBEoNIH3FPJHa60ep123', $paymentCredential->getChargeId());
        $this->assertEquals('__tokenized_card__', $paymentCredential->getTokenizedCard());
        $this->assertEquals('tokenized cvv', $paymentCredential->getTokenizedCvv());
        $this->assertEquals('3', $paymentCredential->getTokenExpiryMonth());
        $this->assertEquals('2019', $paymentCredential->getTokenExpiryYear());
        $this->assertEquals('123456789', $paymentCredential->getFbPaymentId());
    }

    public function testPaymentShippingAddress()
    {
        $shippingAddress = $this->payment->getShippingAddress();

        $this->assertEquals('1 Hacker Way', $shippingAddress->getStreet());
        $this->assertEquals('', $shippingAddress->getAdditionalStreet());
        $this->assertEquals('MENLO PARK', $shippingAddress->getCity());
        $this->assertEquals('CA', $shippingAddress->getState());
        $this->assertEquals('US', $shippingAddress->getCountry());
        $this->assertEquals('94025', $shippingAddress->getPostalCode());
    }

    public function tearDown()
    {
        unset($this->payment);
    }
}