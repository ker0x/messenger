<?php

namespace Kerox\Messenger\Model\Callback;

use Kerox\Messenger\Model\Callback\Payment\PaymentCredential;
use Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Kerox\Messenger\Model\Common\Address;

class Payment
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
     * @var \Kerox\Messenger\Model\Callback\Payment\PaymentCredential
     */
    protected $paymentCredential;

    /**
     * @var array
     */
    protected $amount;

    /**
     * @var string
     */
    protected $shippingOptionId;

    /**
     * Payment constructor.
     *
     * @param string                                                    $payload
     * @param \Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo $requestedUserInfo
     * @param \Kerox\Messenger\Model\Callback\Payment\PaymentCredential $paymentCredential
     * @param array                                                     $amount
     * @param string                                                    $shippingOptionId
     */
    public function __construct(
        string $payload,
        RequestedUserInfo $requestedUserInfo,
        PaymentCredential $paymentCredential,
        array $amount,
        string $shippingOptionId
    ) {
        $this->payload = $payload;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->paymentCredential = $paymentCredential;
        $this->amount = $amount;
        $this->shippingOptionId = $shippingOptionId;
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
     * @return \Kerox\Messenger\Model\Callback\Payment\PaymentCredential
     */
    public function getPaymentCredential(): PaymentCredential
    {
        return $this->paymentCredential;
    }

    /**
     * @return null|string
     */
    public function getCurrency(): ?string
    {
        return $this->amount['currency'] ?? null;
    }

    /**
     * @return null|string
     */
    public function getAmount(): ?string
    {
        return $this->amount['amount'] ?? null;
    }

    /**
     * @return string
     */
    public function getShippingOptionId(): string
    {
        return $this->shippingOptionId;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Payment
     */
    public static function create(array $callbackData): self
    {
        $requestedUserInfo = RequestedUserInfo::create($callbackData['requested_user_info']);
        $paymentCredential = PaymentCredential::create($callbackData['payment_credential']);

        return new static(
            $callbackData['payload'],
            $requestedUserInfo,
            $paymentCredential,
            $callbackData['amount'],
            $callbackData['shipping_option_id']
        );
    }
}
