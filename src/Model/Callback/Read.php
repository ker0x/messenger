<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Read
{
    /**
     * @var int
     */
    protected $watermark;

    /**
     * @var int
     */
    protected $sequence;

    /**
     * Read constructor.
     *
     * @param int $watermark
     * @param int $sequence
     */
    public function __construct(int $watermark, int $sequence)
    {
        $this->watermark = $watermark;
        $this->sequence = $sequence;
    }

    /**
     * @return int
     */
    public function getWatermark(): int
    {
        return $this->watermark;
    }

    /**
     * @return int
     */
    public function getSequence(): int
    {
        return $this->sequence;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Read
     */
    public static function create(array $callbackData): self
    {
        return new static($callbackData['watermark'], $callbackData['seq']);
    }
}
