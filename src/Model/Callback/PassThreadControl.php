<?php

namespace Kerox\Messenger\Model\Callback;

class PassThreadControl
{
    /**
     * @var string
     */
    protected $newOwnerAppId;

    /**
     * @var string
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     *
     * @param string $newOwnerAppId
     * @param string $metadata
     */
    public function __construct(string $newOwnerAppId, string $metadata)
    {
        $this->newOwnerAppId = $newOwnerAppId;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getNewOwnerAppId(): string
    {
        return $this->newOwnerAppId;
    }

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param array $payload
     *
     * @return \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    public static function create(array $payload): PassThreadControl
    {
        return new static($payload['new_owner_app_id'], $payload['metadata']);
    }
}
