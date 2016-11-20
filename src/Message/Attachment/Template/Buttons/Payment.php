<?php
namespace Kerox\Messenger\Message\Attachment\Template\Buttons;

use Kerox\Messenger\Message\Attachment\Template\Buttons\Payment\PaymentSummary;

class Payment extends AbstractButtons
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
     * @var \Kerox\Messenger\Message\Attachment\Template\Buttons\Payment\PaymentSummary
     */
    protected $paymentSummary;

    /**
     * Payment constructor.
     *
     * @param string $payload
     * @param \Kerox\Messenger\Message\Attachment\Template\Buttons\Payment\PaymentSummary $paymentSummary
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
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'title' => $this->title,
            'payload' => $this->payload,
            'payment_summary' => $this->paymentSummary,
        ];

        return $json;
    }
}
