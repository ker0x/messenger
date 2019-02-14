<?php

declare(strict_types=1);

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
     * @param string                                                    $payload
     * @param \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo $requestedUserInfo
     * @param array                                                     $amount
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
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->amount['currency'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount['amount'] ?? null;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\PreCheckout
     */
    public static function create(array $callbackData): self
    {
        $requestedUserInfo = RequestedUserInfo::create($callbackData['requested_user_info']);

        return new self($callbackData['payload'], $requestedUserInfo, $callbackData['amount']);
    }
}
