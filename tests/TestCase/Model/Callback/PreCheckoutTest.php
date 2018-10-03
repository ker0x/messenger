<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Kerox\Messenger\Model\Callback\PreCheckout;
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PreCheckoutTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\PreCheckout
     */
    protected $preCheckout;

    public function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/pre_checkout.json');
        $array = json_decode($json, true);

        $this->preCheckout = PreCheckout::create($array['pre_checkout']);
    }

    public function testPreCheckoutCallback(): void
    {
        $this->assertSame('DEVELOPER_DEFINED_PAYLOAD', $this->preCheckout->getPayload());
        $this->assertSame('USD', $this->preCheckout->getCurrency());
        $this->assertSame('29.62', $this->preCheckout->getAmount());
        $this->assertInstanceOf(RequestedUserInfo::class, $this->preCheckout->getRequestedUserInfo());
        $this->assertInstanceOf(Address::class, $this->preCheckout->getShippingAddress());
    }

    public function testPaymentRequestedUserInfo(): void
    {
        $requestedUserInfo = $this->preCheckout->getRequestedUserInfo();

        $this->assertSame('Peter Chang', $requestedUserInfo->getContactName());
    }

    public function testPaymentShippingAddress(): void
    {
        $shippingAddress = $this->preCheckout->getShippingAddress();

        $this->assertSame('Peter Chang', $shippingAddress->getName());
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
