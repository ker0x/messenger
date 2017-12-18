<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Model\Common\Button\Payment\PaymentSummary;

class Payment extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\Payment\PaymentSummary
     */
    protected $paymentSummary;

    /**
     * Payment constructor.
     *
     * @param string                                                      $payload
     * @param \Kerox\Messenger\Model\Common\Button\Payment\PaymentSummary $paymentSummary
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $payload, PaymentSummary $paymentSummary)
    {
        parent::__construct(self::TYPE_PAYMENT);

        $this->isValidString($payload, 1000);

        $this->title = 'buy';
        $this->payload = $payload;
        $this->paymentSummary = $paymentSummary;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'title'           => $this->title,
            'payload'         => $this->payload,
            'payment_summary' => $this->paymentSummary,
        ];

        return $array;
    }
}
