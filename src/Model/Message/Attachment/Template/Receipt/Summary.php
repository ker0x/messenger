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
     *
     * @param float $totalCost
     */
    public function __construct(float $totalCost)
    {
        $this->totalCost = $totalCost;
    }

    /**
     * @param float $subtotal
     *
     * @return Summary
     */
    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * @param float $shippingCost
     *
     * @return Summary
     */
    public function setShippingCost(float $shippingCost): self
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @param float $totalTax
     *
     * @return Summary
     */
    public function setTotalTax(float $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'subtotal'      => $this->subtotal,
            'shipping_cost' => $this->shippingCost,
            'total_tax'     => $this->totalTax,
            'total_cost'    => $this->totalCost,
        ];

        return array_filter($json);
    }
}
