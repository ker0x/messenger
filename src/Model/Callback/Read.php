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
     * Read constructor.
     *
     * @param int $watermark
     */
    public function __construct(int $watermark)
    {
        $this->watermark = $watermark;
    }

    /**
     * @return int
     */
    public function getWatermark(): int
    {
        return $this->watermark;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Read
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['watermark']);
    }
}
