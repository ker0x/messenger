<?php

namespace Kerox\Messenger\Model\Callback;

use Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Kerox\Messenger\Model\Common\Address;

class PreCheckout
{

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo
     */
    protected $requestedUserInfo;

    /**
     * @var array
     */
    protected $amount;

    /**
     * PreCheckout constructor.
     *
     * @param string $payload
     * @param \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo $requestedUserInfo
     * @param array $amount
     */
    public function __construct(string $payload, RequestedUserInfo $requestedUserInfo, array $amount)
    {
        $this->payload = $payload;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo
     */
    public function getRequestedUserInfo(): RequestedUserInfo
    {
        return $this->requestedUserInfo;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Address
     */
    public function getShippingAddress(): Address
    {
        return $this->requestedUserInfo->getShippingAddress();
    }

    /**
     * @return null|string
     */
    public function getCurrency()
    {
        return $this->amount['currency'] ?? null;
    }

    /**
     * @return null|string
     */
    public function getAmount()
    {
        return $this->amount['amount'] ?? null;
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Model\Callback\PreCheckout
     */
    public static function create(array $payload): PreCheckout
    {
        $requestedUserInfo = RequestedUserInfo::create($payload['requested_user_info']);

        return new static($payload['payload'], $requestedUserInfo, $payload['amount']);
    }
}
