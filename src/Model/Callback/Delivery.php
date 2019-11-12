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
     */
    public function __construct(int $watermark, array $messageIds = [])
    {
        $this->watermark = $watermark;
        $this->messageIds = $messageIds;
    }

    public function getWatermark(): int
    {
        return $this->watermark;
    }

    public function getMessageIds(): array
    {
        return $this->messageIds;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Delivery
     */
    public static function create(array $callbackData): self
    {
        $messageIds = $callbackData['mids'] ?? [];

        return new self($callbackData['watermark'], $messageIds);
    }
}
