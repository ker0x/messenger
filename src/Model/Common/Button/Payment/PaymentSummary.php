<?php

namespace Kerox\Messenger\Model\Common\Button\Payment;

class PaymentSummary implements \JsonSerializable
{

    const PAYMENT_TYPE_FIXED_AMOUNT = 'FIXED_AMOUNT';
    const PAYMENT_TYPE_FLEXIBLE_AMOUNT = 'FLEXIBLE_AMOUNT';

    const USER_INFO_SHIPPING_ADDRESS = 'shipping_address';
    const USER_INFO_CONTACT_NAME = 'contact_name';
    const USER_INFO_CONTACT_PHONE = 'contact_phone';
    const USER_INFO_CONTACT_EMAIL = 'contact_email';

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var null|bool
     */
    protected $isTestPayment;

    /**
     * @var string
     */
    protected $paymentType;

    /**
     * @var string
     */
    protected $merchantName;

    /**
     * @var array
     */
    protected $requestedUserInfo = [];

    /**
     * @var array
     */
    protected $priceList = [];

    /**
     * PaymentSummary constructor.
     *
     * @param string $currency
     * @param string $paymentType
     * @param string $merchantName
     * @param array $requestedUserInfo
     * @param PriceList[] $priceList
     */
    public function __construct(
        string $currency,
        string $paymentType,
        string $merchantName,
        array $requestedUserInfo,
        array $priceList
    ) {
        $this->isValidPaymentType($paymentType);
        $this->isValidRequestedUserInfo($requestedUserInfo);

        $this->currency = $currency;
        $this->paymentType = $paymentType;
        $this->merchantName = $merchantName;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->priceList = $priceList;
    }

    /**
     * @param bool $isTestPayment
     * @return PaymentSummary
     */
    public function isTestPayment(bool $isTestPayment): PaymentSummary
    {
        $this->isTestPayment = $isTestPayment;

        return $this;
    }

    /**
     * @param string $label
     * @param string $amount
     * @internal param array $priceList
     * @return PaymentSummary
     */
    public function addPriceList(string $label, string $amount): PaymentSummary
    {
        $this->priceList[] = new PriceList($label, $amount);

        return $this;
    }

    /**
     * @param string $paymentType
     * @return void
     * @throws \InvalidArgumentException
     */
    private function isValidPaymentType(string $paymentType)
    {
        $allowedPaymentType = $this->getAllowedPaymentType();
        if (!in_array($paymentType, $allowedPaymentType)) {
            throw new \InvalidArgumentException('$paymentType must be either ' . implode(', ', $allowedPaymentType));
        }
    }

    /**
     * @return array
     */
    private function getAllowedPaymentType(): array
    {
        return [
            self::PAYMENT_TYPE_FIXED_AMOUNT,
            self::PAYMENT_TYPE_FLEXIBLE_AMOUNT,
        ];
    }

    /**
     * @param array $requestedUserInfo
     * @return void
     * @throws \InvalidArgumentException
     */
    private function isValidRequestedUserInfo(array $requestedUserInfo)
    {
        $allowedUserInfo = $this->getAllowedUserInfo();
        foreach ($requestedUserInfo as $userInfo) {
            if (!in_array($userInfo, $allowedUserInfo)) {
                throw new \InvalidArgumentException("$userInfo is not a valid value. Valid values are " . implode(',', $allowedUserInfo));
            }
        }
    }

    /**
     * @return array
     */
    private function getAllowedUserInfo(): array
    {
        return [
            self::USER_INFO_SHIPPING_ADDRESS,
            self::USER_INFO_CONTACT_NAME,
            self::USER_INFO_CONTACT_PHONE,
            self::USER_INFO_CONTACT_EMAIL,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'currency' => $this->currency,
            'payment_type' => $this->paymentType,
            'is_test_payment' => $this->isTestPayment,
            'merchant_name' => $this->merchantName,
            'requested_user_info' => $this->requestedUserInfo,
            'price_list' => $this->priceList,
        ];

        return array_filter($json);
    }
}
