<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Delivery
{
    /**
     * @var int
     */
    protected $watermark;

    /**
     * @var array
     */
    protected $messageIds;

    /**
     * Delivery constructor.
     *
     * @param array $messageIds
     * @param int   $watermark
     */
    public function __construct(int $watermark, array $messageIds = [])
    {
        $this->watermark = $watermark;
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
     * @return array
     */
    public function getMessageIds(): array
    {
        return $this->messageIds;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Delivery
     */
    public static function create(array $callbackData): self
    {
        $messageIds = $callbackData['mids'] ?? [];

        return new self($callbackData['watermark'], $messageIds);
    }
}
