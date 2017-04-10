<?php

namespace Kerox\Messenger\Model\Callback;

class Delivery
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
     * @var array
     */
    protected $messageIds;

    /**
     * Delivery constructor.
     *
     * @param array $messageIds
     * @param int $watermark
     * @param int $sequence
     */
    public function __construct(int $watermark, int $sequence, array $messageIds = [])
    {
        $this->watermark = $watermark;
        $this->sequence = $sequence;
        $this->messageIds = $messageIds;
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
     * @return array
     */
    public function getMessageIds(): array
    {
        return $this->messageIds;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function create(array $payload)
    {
        $messageIds = $payload['mids'] ?? [];

        return new static($payload['watermark'], $payload['seq'], $messageIds);
    }
}
