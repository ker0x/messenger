<?php
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

    public function setUp()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Event/pre_checkout.json');
        $array = json_decode($json, true);

        $this->preCheckout = PreCheckout::create($array['pre_checkout']);
    }

    public function testPreCheckoutModel()
    {
        $this->assertEquals('DEVELOPER_DEFINED_PAYLOAD', $this->preCheckout->getPayload());
        $this->assertEquals('USD', $this->preCheckout->getCurrency());
        $this->assertEquals('29.62', $this->preCheckout->getAmount());
        $this->assertInstanceOf(RequestedUserInfo::class, $this->preCheckout->getRequestedUserInfo());
        $this->assertInstanceOf(Address::class, $this->preCheckout->getShippingAddress());
    }

    public function testPaymentRequestedUserInfo()
    {
        $requestedUserInfo = $this->preCheckout->getRequestedUserInfo();

        $this->assertEquals('Peter Chang', $requestedUserInfo->getContactName());
    }

    public function testPaymentShippingAddress()
    {
        $shippingAddress = $this->preCheckout->getShippingAddress();

        $this->assertEquals('Peter Chang', $shippingAddress->getName());
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