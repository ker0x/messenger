<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class RequestThreadControl
{
    /**
     * @var string
     */
    protected $requestedOwnerAppId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     *
     * @param int         $requestedOwnerAppId
     * @param string|null $metadata
     */
    public function __construct(int $requestedOwnerAppId, ?string $metadata)
    {
        $this->requestedOwnerAppId = $requestedOwnerAppId;
        $this->metadata = $metadata;
    }

    /**
     * @return int
     */
    public function getRequestedOwnerAppId(): int
    {
        return $this->requestedOwnerAppId;
    }

    /**
     * @return string|null
     */
    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\RequestThreadControl
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['requested_owner_app_id'], $callbackData['metadata']);
    }
}
