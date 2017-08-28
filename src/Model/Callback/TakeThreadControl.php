<?php

namespace Kerox\Messenger\Model\Callback;

class TakeThreadControl
{
    /**
     * @var string
     */
    protected $previousOwnerAppId;

    /**
     * @var string
     */
    protected $metadata;

    /**
     * TakeThreadControl constructor.
     *
     * @param string $previousOwnerAppId
     * @param string $metadata
     */
    public function __construct(string $previousOwnerAppId, string $metadata)
    {
        $this->previousOwnerAppId = $previousOwnerAppId;
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getPreviousOwnerAppId(): string
    {
        return $this->previousOwnerAppId;
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
     * @return \Kerox\Messenger\Model\Callback\TakeThreadControl
     */
    public static function create(array $payload): TakeThreadControl
    {
        return new static($payload['previous_owner_app_id'], $payload['metadata']);
    }
}
