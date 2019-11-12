<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class PassThreadControl
{
    /**
     * @var int
     */
    protected $newOwnerAppId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     */
    public function __construct(int $newOwnerAppId, ?string $metadata)
    {
        $this->newOwnerAppId = $newOwnerAppId;
        $this->metadata = $metadata;
    }

    public function getNewOwnerAppId(): int
    {
        return $this->newOwnerAppId;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['new_owner_app_id'], $callbackData['metadata']);
    }
}
