<?php

declare(strict_types=1);

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
     * @param $newOwnerAppId
     * @param string|null $metadata
     */
    public function __construct($newOwnerAppId, ?string $metadata)
    {
        $this->newOwnerAppId = (string)$newOwnerAppId;
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
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['new_owner_app_id'], $callbackData['metadata']);
    }
}
