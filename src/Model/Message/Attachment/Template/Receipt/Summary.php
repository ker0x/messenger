<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Receipt;

class Summary implements \JsonSerializable
{
    /**
     * @var float
     */
    protected $subtotal;

    /**
     * @var float
     */
    protected $shippingCost;

    /**
     * @var float
     */
    protected $totalTax;

    /**
     * @var float
     */
    protected $totalCost;

    /**
     * Summary constructor.
     */
    public function __construct(float $totalCost)
    {
        $this->totalCost = $totalCost;
    }

    /**
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary
     */
    public static function create(float $totalCost): self
    {
        return new self($totalCost);
    }

    /**
     * @return Summary
     */
    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * @return Summary
     */
    public function setShippingCost(float $shippingCost): self
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @return Summary
     */
    public function setTotalTax(float $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'subtotal' => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'total_tax' => $this->totalTax,
            'total_cost' => $this->totalCost,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
