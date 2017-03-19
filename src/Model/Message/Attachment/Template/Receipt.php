<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Message\Attachment\Template;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;

class Receipt extends Template
{

    /**
     * @var string
     */
    protected $recipientName;

    /**
     * @var string
     */
    protected $orderNumber;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $orderUrl;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement[]
     */
    protected $elements;

    /**
     * @var null|\Kerox\Messenger\Model\Common\Address
     */
    protected $address;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary
     */
    protected $summary;

    /**
     * @var null|\Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment[]
     */
    protected $adjustments;

    /**
     * Receipt constructor.
     *
     * @param string $recipientName
     * @param string $orderNumber
     * @param string $currency
     * @param string $paymentMethod
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement[] $elements
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary $summary
     */
    public function __construct(
        string $recipientName,
        string $orderNumber,
        string $currency,
        string $paymentMethod,
        array $elements,
        Summary $summary
    ) {
        parent::__construct();

        $this->isValidArray($elements, 100);

        $this->recipientName = $recipientName;
        $this->orderNumber = $orderNumber;
        $this->currency = $currency;
        $this->paymentMethod = $paymentMethod;
        $this->elements = $elements;
        $this->summary = $summary;
    }

    /**
     * @param string $timestamp
     * @return Receipt
     */
    public function setTimestamp(string $timestamp): Receipt
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @param string $orderUrl
     * @return Receipt
     */
    public function setOrderUrl(string $orderUrl): Receipt
    {
        $this->isValidUrl($orderUrl);
        $this->orderUrl = $orderUrl;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Address $address
     * @return Receipt
     */
    public function setAddress(Address $address): Receipt
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment[] $adjustments
     * @return Receipt
     */
    public function setAdjustments(array $adjustments): Receipt
    {
        $this->adjustments = $adjustments;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type' => Template::TYPE_RECEIPT,
                'recipient_name' => $this->recipientName,
                'order_number' => $this->orderNumber,
                'currency' => $this->currency,
                'payment_method' => $this->paymentMethod,
                'order_url' => $this->orderUrl,
                'timestamp' => $this->timestamp,
                'elements' => $this->elements,
                'address' => $this->address,
                'summary' => $this->summary,
                'adjustments' => $this->adjustments,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
