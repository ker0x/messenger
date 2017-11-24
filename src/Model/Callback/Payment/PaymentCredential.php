<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback\Payment;

class PaymentCredential
{
    /**
     * @var string
     */
    protected $providerType;

    /**
     * @var string
     */
    protected $chargeId;

    /**
     * @var null|string
     */
    protected $tokenizedCard;

    /**
     * @var null|string
     */
    protected $tokenizedCvv;

    /**
     * @var null|string
     */
    protected $tokenExpiryMonth;

    /**
     * @var null|string
     */
    protected $tokenExpiryYear;

    /**
     * @var string
     */
    protected $fbPaymentId;

    /**
     * PaymentCredential constructor.
     *
     * @param string $providerType
     * @param string $chargeId
     * @param string $tokenizedCard
     * @param string $tokenizedCvv
     * @param string $tokenExpiryMonth
     * @param string $tokenExpiryYear
     * @param string $fbPaymentId
     */
    public function __construct(
        string $providerType,
        string $chargeId,
        ?string $tokenizedCard = null,
        ?string $tokenizedCvv = null,
        ?string $tokenExpiryMonth = null,
        ?string $tokenExpiryYear = null,
        string $fbPaymentId
    ) {
        $this->providerType = $providerType;
        $this->chargeId = $chargeId;
        $this->tokenizedCard = $tokenizedCard;
        $this->tokenizedCvv = $tokenizedCvv;
        $this->tokenExpiryMonth = $tokenExpiryMonth;
        $this->tokenExpiryYear = $tokenExpiryYear;
        $this->fbPaymentId = $fbPaymentId;
    }

    /**
     * @return string
     */
    public function getProviderType(): string
    {
        return $this->providerType;
    }

    /**
     * @return string
     */
    public function getChargeId(): string
    {
        return $this->chargeId;
    }

    /**
     * @return null|string
     */
    public function getTokenizedCard(): ?string
    {
        return $this->tokenizedCard;
    }

    /**
     * @return null|string
     */
    public function getTokenizedCvv(): ?string
    {
        return $this->tokenizedCvv;
    }

    /**
     * @return null|string
     */
    public function getTokenExpiryMonth(): ?string
    {
        return $this->tokenExpiryMonth;
    }

    /**
     * @return null|string
     */
    public function getTokenExpiryYear(): ?string
    {
        return $this->tokenExpiryYear;
    }

    /**
     * @return string
     */
    public function getFbPaymentId(): string
    {
        return $this->fbPaymentId;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Payment\PaymentCredential
     */
    public static function create(array $callbackData): self
    {
        $tokenizedCard = $callbackData['tokenized_card'] ?? null;
        $tokenizedCvv = $callbackData['tokenized_cvv'] ?? null;
        $tokenExpiryMonth = $callbackData['token_expiry_month'] ?? null;
        $tokenExpiryYear = $callbackData['token_expiry_year'] ?? null;

        return new static(
            $callbackData['provider_type'],
            $callbackData['charge_id'],
            $tokenizedCard,
            $tokenizedCvv,
            $tokenExpiryMonth,
            $tokenExpiryYear,
            $callbackData['fb_payment_id']
        );
    }
}
