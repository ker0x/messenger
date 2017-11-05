<?php

namespace Kerox\Messenger\Model\Callback;

class MessageEcho extends Message
{
    /**
     * @var bool
     */
    protected $isEcho;

    /**
     * @var null|int
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
     * @param null|int    $appId
     * @param string      $messageId
     * @param int         $sequence
     * @param string|null $metadata
     * @param string|null $text
     * @param string|null $quickReply
     * @param array       $attachments
     */
    public function __construct(
        bool $isEcho,
        ?int $appId = null,
        string $messageId,
        int $sequence,
        ?string $metadata = null,
        ?string $text = null,
        ?string $quickReply = null,
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
     * @return null|int
     */
    public function getAppId(): ?int
    {
        return $this->appId;
    }

    /**
     * @return null|string
     */
    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\MessageEcho
     */
    public static function create(array $callbackData)
    {
        $appId = $callbackData['app_id'] ?? null;
        $metadata = $callbackData['metadata'] ?? null;
        $text = $callbackData['text'] ?? null;
        $quickReply = $callbackData['quick_reply']['payload'] ?? null;
        $attachments = $callbackData['attachments'] ?? [];

        return new static(
            true,
            $appId,
            $callbackData['mid'],
            $callbackData['seq'],
            $metadata,
            $text,
            $quickReply,
            $attachments
        );
    }
}
