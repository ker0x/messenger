<?php

declare(strict_types=1);

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

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getRequestedUserInfo(): RequestedUserInfo
    {
        return $this->requestedUserInfo;
    }

    public function getShippingAddress(): Address
    {
        return $this->requestedUserInfo->getShippingAddress();
    }

    public function getPaymentCredential(): PaymentCredential
    {
        return $this->paymentCredential;
    }

    public function getCurrency(): ?string
    {
        return $this->amount['currency'] ?? null;
    }

    public function getAmount(): ?string
    {
        return $this->amount['amount'] ?? null;
    }

    public function getShippingOptionId(): string
    {
        return $this->shippingOptionId;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Payment
     */
    public static function create(array $callbackData): self
    {
        $requestedUserInfo = RequestedUserInfo::create($callbackData['requested_user_info']);
        $paymentCredential = PaymentCredential::create($callbackData['payment_credential']);

        return new self(
            $callbackData['payload'],
            $requestedUserInfo,
            $paymentCredential,
            $callbackData['amount'],
            $callbackData['shipping_option_id']
        );
    }
}
