<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;

class ThreadControl implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var int
     */
    protected $recipientId;

    /**
     * @var int|null
     */
    protected $targetAppId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * PassThreadControl constructor.
     */
    public function __construct(int $recipientId, ?int $targetAppId = null)
    {
        $this->recipientId = $recipientId;
        $this->targetAppId = $targetAppId;
    }

    /**
     * @return \Kerox\Messenger\Model\ThreadControl
     */
    public static function create(int $recipientId, ?int $targetAppId = null): self
    {
        return new self($recipientId, $targetAppId);
    }

    /**
     * @throws \Exception
     */
    public function setMetadata(string $metadata): void
    {
        $this->isValidString($metadata, 1000);

        $this->metadata = $metadata;
    }

    public function toArray(): array
    {
        $array = [
            'recipient' => [
                'id' => $this->recipientId,
            ],
            'target_app_id' => $this->targetAppId,
            'metadata' => $this->metadata,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
