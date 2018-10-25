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
     * @var string
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     *
     * @param $requestedOwnerAppId
     * @param string $metadata
     */
    public function __construct($requestedOwnerAppId, string $metadata)
    {
        $this->requestedOwnerAppId = (string)$requestedOwnerAppId;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getRequestedOwnerAppId(): string
    {
        return $this->requestedOwnerAppId;
    }

    /**
     * @return string
     */
    public function getMetadata(): string
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
