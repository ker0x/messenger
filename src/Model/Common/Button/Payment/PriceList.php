<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button\Payment;

class PriceList implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $amount;

    /**
     * PriceList constructor.
     *
     * @param string $label
     * @param string $amount
     */
    public function __construct(string $label, string $amount)
    {
        $this->label = $label;
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'label'  => $this->label,
            'amount' => $this->amount,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
