<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

class ReceiptElement extends AbstractElement
{
    /**
     * @var int|null
     */
    protected $quantity;

    /**
     * @var float|null
     */
    protected $price;

    /**
     * @var string|null
     */
    protected $currency;

    /**
     * Element constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $title, float $price)
    {
        parent::__construct($title);

        $this->price = $price;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement
     */
    public static function create(string $title, float $price): self
    {
        return new self($title, $price);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement
     */
    public function setSubtitle(string $subtitle): self
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement
     */
    public function setImageUrl(string $imageUrl): self
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @return ReceiptElement
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return ReceiptElement
     */
    public function setCurrency(string $currency): self
    {
        $this->isValidCurrency($currency);

        $this->currency = $currency;

        return $this;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'subtitle' => $this->subtitle,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency,
            'image_url' => $this->imageUrl,
        ];

        return array_filter($array);
    }
}
