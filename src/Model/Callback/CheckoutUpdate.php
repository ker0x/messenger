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
     */
    public function __construct(string $payload, Address $shippingAddress)
    {
        $this->payload = $payload;
        $this->shippingAddress = $shippingAddress;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\CheckoutUpdate
     */
    public static function create(array $callbackData): self
    {
        $shippingAddress = Address::fromPayload($callbackData['shipping_address']);

        return new self($callbackData['payload'], $shippingAddress);
    }
}
