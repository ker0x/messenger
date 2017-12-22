<?php

declare(strict_types=1);

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
     * @param string                                $payload
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
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\CheckoutUpdate
     */
    public static function create(array $callbackData): self
    {
        $shippingAddress = Address::fromPayload($callbackData['shipping_address']);

        return new self($callbackData['payload'], $shippingAddress);
    }
}
