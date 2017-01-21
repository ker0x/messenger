<?php
namespace Kerox\Messenger\Model\Callback;

use Kerox\Messenger\Model\Common\Address;

class CheckoutUpdate
{

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var \Kerox\Messenger\Model\Common\Address
     */
    protected $shippingAddress;

    /**
     * CheckoutUpdate constructor.
     *
     * @param string $payload
     * @param \Kerox\Messenger\Model\Common\Address $shippingAddress
     */
    public function __construct(string $payload, Address $shippingAddress)
    {
        $this->payload = $payload;
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $shippingAddress = Address::create($payload['shipping_address']);

        return new static($payload['payload'], $shippingAddress);
    }
}
