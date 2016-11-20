<?php
namespace Kerox\Messenger\Message\Attachment\Template\Buttons\Payment;


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
    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label,
            'amount' => $this->amount,
        ];
    }
}