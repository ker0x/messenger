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
     * @param string $contactEmail
     * @param string $contactPhone
     */
    public function __construct(Address $shippingAddress, string $contactName, string $contactEmail, string $contactPhone)
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
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @return string
     */
    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $shippingAddress = Address::create($payload['shipping_address']);

        return new static($shippingAddress, $payload['contact_name'], $payload['contact_email'], $payload['contact_phone']);
    }
}
