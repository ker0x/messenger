<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback\Payment;

use Kerox\Messenger\Model\Common\Address;

class RequestedUserInfo
{
    /**
     * @var \Kerox\Messenger\Model\Common\Address
     */
    protected $shippingAddress;

    /**
     * @var string
     */
    protected $contactName;

    /**
     * @var string|null
     */
    protected $contactEmail;

    /**
     * @var string|null
     */
    protected $contactPhone;

    /**
     * RequestedUserInfo constructor.
     */
    public function __construct(
        Address $shippingAddress,
        string $contactName,
        ?string $contactEmail = null,
        ?string $contactPhone = null
    ) {
        $this->shippingAddress = $shippingAddress;
        $this->contactName = $contactName;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo
     */
    public static function create(array $callbackData): self
    {
        $shippingAddress = Address::fromPayload($callbackData['shipping_address']);

        $contactEmail = $callbackData['contact_email'] ?? null;
        $contactPhone = $callbackData['contact_phone'] ?? null;

        return new self($shippingAddress, $callbackData['contact_name'], $contactEmail, $contactPhone);
    }
}
