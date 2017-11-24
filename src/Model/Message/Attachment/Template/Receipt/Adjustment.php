<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Receipt;

class Adjustment implements \JsonSerializable
{
    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var null|float
     */
    protected $amount;

    /**
     * Adjustment constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $name
     *
     * @return Adjustment
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param float $amount
     *
     * @return Adjustment
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'name'   => $this->name,
            'amount' => $this->amount,
        ];

        return array_filter($json);
    }
}
