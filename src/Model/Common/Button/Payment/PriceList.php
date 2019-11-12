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
     */
    public function __construct(string $label, string $amount)
    {
        $this->label = $label;
        $this->amount = $amount;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Button\Payment\PriceList
     */
    public static function create(string $label, string $amount): self
    {
        return new self($label, $amount);
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'amount' => $this->amount,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
