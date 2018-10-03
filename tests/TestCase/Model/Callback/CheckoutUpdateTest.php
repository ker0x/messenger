<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Callback;

use Kerox\Messenger\Model\Callback\CheckoutUpdate;
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class CheckoutUpdateTest extends AbstractTestCase
{
    /**
     * @var \Kerox\Messenger\Model\Callback\CheckoutUpdate
     */
    protected $checkoutUpdate;

    public function setUp(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/checkout_update.json');
        $array = json_decode($json, true);

        $this->checkoutUpdate = CheckoutUpdate::create($array['checkout_update']);
    }

    public function testCheckoutUpdateCallback(): void
    {
        $this->assertSame('DEVELOPER_DEFINED_PAYLOAD', $this->checkoutUpdate->getPayload());
        $this->assertInstanceOf(Address::class, $this->checkoutUpdate->getShippingAddress());
    }

    public function testCheckoutUpdateShippingAddress(): void
    {
        $shippingAddress = $this->checkoutUpdate->getShippingAddress();

        $this->assertSame('1 Hacker Way', $shippingAddress->getStreet());
        $this->assertSame('', $shippingAddress->getAdditionalStreet());
        $this->assertSame('MENLO PARK', $shippingAddress->getCity());
        $this->assertSame('CA', $shippingAddress->getState());
        $this->assertSame('US', $shippingAddress->getCountry());
        $this->assertSame('94025', $shippingAddress->getPostalCode());
        $this->assertSame(10105655000959552, $shippingAddress->getId());
    }

    public function tearDown(): void
    {
        unset($this->checkoutUpdate);
    }
}
