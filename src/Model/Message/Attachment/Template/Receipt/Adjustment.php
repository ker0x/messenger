<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Receipt;

class Adjustment implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var float|null
     */
    protected $amount;

    /**
     * Adjustment constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return Adjustment
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Adjustment
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'name' => $this->name,
            'amount' => $this->amount,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
