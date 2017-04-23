<?php

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
     * @var string
     */
    protected $contactEmail;

    /**
     * @var string
     */
    protected $contactPhone;

    /**
     * RequestedUserInfo constructor.
     *
     * @param \Kerox\Messenger\Model\Common\Address $shippingAddress
     * @param string $contactName
     * @param null|string $contactEmail
     * @param null|string $contactPhone
     */
    public function __construct(Address $shippingAddress, string $contactName, $contactEmail = null, $contactPhone = null)
    {
        $this->shippingAddress = $shippingAddress;
        $this->contactName = $contactName;
        $this->contactEmail = $contactEmail;
        $this->contactPhone = $contactPhone;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->contactName;
    }

    /**
     * @return null|string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @return null|string
     */
    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo
     */
    public static function create(array $payload): RequestedUserInfo
    {
        $shippingAddress = Address::create($payload['shipping_address']);

        $contactEmail = $payload['contact_email'] ?? null;
        $contactPhone = $payload['contact_phone'] ?? null;

        return new static($shippingAddress, $payload['contact_name'], $contactEmail, $contactPhone);
    }
}
