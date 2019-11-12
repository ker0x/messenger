<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class TakeThreadControl
{
    /**
     * @var int
     */
    protected $previousOwnerAppId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     */
    public function __construct(int $previousOwnerAppId, ?string $metadata)
    {
        $this->previousOwnerAppId = $previousOwnerAppId;
        $this->metadata = $metadata;
    }

    public function getPreviousOwnerAppId(): int
    {
        return $this->previousOwnerAppId;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\TakeThreadControl
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['previous_owner_app_id'], $callbackData['metadata']);
    }
}
