<?php

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
     * @var string
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
     * @param string $tokenizedCvv
     * @param string $tokenExpiryMonth
     * @param string $tokenExpiryYear
     * @param string $fbPaymentId
     */
    public function __construct(
        string $providerType,
        string $chargeId,
        string $tokenizedCard,
        string $tokenizedCvv,
        string $tokenExpiryMonth,
        string $tokenExpiryYear,
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
     * @return string
     */
    public function getTokenizedCard(): string
    {
        return $this->tokenizedCard;
    }

    /**
     * @return null|string
     */
    public function getTokenizedCvv()
    {
        return $this->tokenizedCvv;
    }

    /**
     * @return null|string
     */
    public function getTokenExpiryMonth()
    {
        return $this->tokenExpiryMonth;
    }

    /**
     * @return null|string
     */
    public function getTokenExpiryYear()
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
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $tokenizedCard = $payload['tokenized_card'] ?? null;
        $tokenizedCvv = $payload['tokenized_cvv'] ?? null;
        $tokenExpiryMonth = $payload['token_expiry_month'] ?? null;
        $tokenExpiryYear = $payload['token_expiry_year'] ?? null;

        return new static($payload['provider_type'], $payload['charge_id'], $tokenizedCard, $tokenizedCvv, $tokenExpiryMonth, $tokenExpiryYear, $payload['fb_payment_id']);
    }
}
