<?php
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

    public function setUp()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/checkout_update.json');
        $array = json_decode($json, true);

        $this->checkoutUpdate = CheckoutUpdate::create($array['checkout_update']);
    }

    public function testCheckoutUpdateModel()
    {
        $this->assertEquals('DEVELOPER_DEFINED_PAYLOAD', $this->checkoutUpdate->getPayload());
        $this->assertInstanceOf(Address::class, $this->checkoutUpdate->getShippingAddress());
    }

    public function testCheckoutUpdateShippingAddress()
    {
        $shippingAddress = $this->checkoutUpdate->getShippingAddress();

        $this->assertEquals('1 Hacker Way', $shippingAddress->getStreet());
        $this->assertEquals('', $shippingAddress->getAdditionalStreet());
        $this->assertEquals('MENLO PARK', $shippingAddress->getCity());
        $this->assertEquals('CA', $shippingAddress->getState());
        $this->assertEquals('US', $shippingAddress->getCountry());
        $this->assertEquals('94025', $shippingAddress->getPostalCode());
        $this->assertEquals(10105655000959552, $shippingAddress->getId());
    }

    public function tearDown()
    {
        unset($this->checkoutUpdate);
    }
}