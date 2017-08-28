<?php

namespace Kerox\Messenger\Model\Callback;

class MessageEcho extends Message
{
    /**
     * @var bool
     */
    protected $isEcho;

    /**
     * @var int
     */
    protected $appId;

    /**
     * @var null|string
     */
    protected $metadata;

    /**
     * MessageEcho constructor.
     *
     * @param bool        $isEcho
     * @param int         $appId
     * @param string      $messageId
     * @param int         $sequence
     * @param string|null $metadata
     * @param string|null $text
     * @param string|null $quickReply
     * @param array       $attachments
     */
    public function __construct(
        bool $isEcho,
        int $appId,
        string $messageId,
        int $sequence,
        string $metadata = null,
        string $text = null,
        string $quickReply = null,
        array $attachments = []
    ) {
        parent::__construct($messageId, $sequence, $text, $quickReply, $attachments);

        $this->isEcho = $isEcho;
        $this->appId = $appId;
        $this->metadata = $metadata;
    }

    /**
     * @return bool
     */
    public function isEcho(): bool
    {
        return $this->isEcho;
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->appId;
    }

    /**
     * @return null|string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $payload
     *
     * @return \Kerox\Messenger\Model\Callback\MessageEcho
     */
    public static function create(array $payload)
    {
	    $appId = $payload['app_id'] ?? null;
        $metadata = $payload['metadata'] ?? null;
        $text = $payload['text'] ?? null;
        $quickReply = $payload['quick_reply']['payload'] ?? null;
        $attachments = $payload['attachments'] ?? [];

        return new static(true, $appId, $payload['mid'], $payload['seq'], $metadata, $text, $quickReply, $attachments);
    }
}
