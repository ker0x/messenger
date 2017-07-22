<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

class ReceiptElement extends AbstractElement
{

    /**
     * @var null|int
     */
    protected $quantity;

    /**
     * @var null|float
     */
    protected $price;

    /**
     * @var null|string
     */
    protected $currency;

    /**
     * Element constructor.
     *
     * @param string $title
     * @param float $price
     */
    public function __construct(string $title, float $price)
    {
        parent::__construct($title);

        $this->price = $price;
    }

    /**
     * @param string $subtitle
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement
     */
    public function setSubtitle(string $subtitle): ReceiptElement
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @param string $imageUrl
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement
     */
    public function setImageUrl(string $imageUrl): ReceiptElement
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @param int $quantity
     * @return ReceiptElement
     */
    public function setQuantity(int $quantity): ReceiptElement
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param string $currency
     * @return ReceiptElement
     */
    public function setCurrency(string $currency): ReceiptElement
    {
        $this->isValidCurrency($currency);

        $this->currency = $currency;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'subtitle' => $this->subtitle,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
        ];

        return array_filter($json);
    }
}
