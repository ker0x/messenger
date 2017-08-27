<?php

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
     * @param array $payload
     *
     * @return \Kerox\Messenger\Model\Callback\Read
     */
    public static function create(array $payload): Read
    {
        return new static($payload['watermark'], $payload['seq']);
    }
}
