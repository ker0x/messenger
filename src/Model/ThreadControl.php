<?php

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
     * @var null|int
     */
    protected $targetAppId;

    /**
     * @var null|string
     */
    protected $metadata;

    /**
     * PassThreadControl constructor.
     *
     * @param int      $recipientId
     * @param int|null $targetAppId
     */
    public function __construct(int $recipientId, int $targetAppId = null)
    {
        $this->recipientId = $recipientId;
        $this->targetAppId = $targetAppId;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata(string $metadata): void
    {
        $this->isValidString($metadata, 1000);

        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'recipient'     => [
                'id' => $this->recipientId
            ],
            'target_app_id' => $this->targetAppId,
            'metadata'      => $this->metadata,
        ];

        return array_filter($json);
    }
}
