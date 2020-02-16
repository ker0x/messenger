<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class RequestThreadControl
{
    /**
     * @var int
     */
    protected $requestedOwnerAppId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     */
    public function __construct(int $requestedOwnerAppId, ?string $metadata)
    {
        $this->requestedOwnerAppId = $requestedOwnerAppId;
        $this->metadata = $metadata;
    }

    public function getRequestedOwnerAppId(): int
    {
        return $this->requestedOwnerAppId;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\RequestThreadControl
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['requested_owner_app_id'], $callbackData['metadata'] ?? null);
    }
}
