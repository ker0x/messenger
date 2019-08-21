<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class MessageEcho extends Message
{
    /**
     * @var bool
     */
    protected $isEcho;

    /**
     * @var int|null
     */
    protected $appId;

    /**
     * @var string|null
     */
    protected $metadata;

    /**
     * MessageEcho constructor.
     *
     * @param bool        $isEcho
     * @param int|null    $appId
     * @param string      $messageId
     * @param string|null $metadata
     * @param string|null $text
     * @param string|null $quickReply
     * @param array       $attachments
     */
    public function __construct(
        bool $isEcho,
        ?int $appId,
        string $messageId,
        ?string $metadata = null,
        ?string $text = null,
        ?string $quickReply = null,
        array $attachments = []
    ) {
        parent::__construct($messageId, $text, $quickReply, $attachments);

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
     * @return int|null
     */
    public function getAppId(): ?int
    {
        return $this->appId;
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
     * @return \Kerox\Messenger\Model\Callback\MessageEcho
     */
    public static function create(array $callbackData)
    {
        $appId = $callbackData['app_id'] ?? null;
        $metadata = $callbackData['metadata'] ?? null;
        $text = $callbackData['text'] ?? null;
        $quickReply = $callbackData['quick_reply']['payload'] ?? null;
        $attachments = $callbackData['attachments'] ?? [];

        return new self(
            true,
            $appId,
            $callbackData['mid'],
            $metadata,
            $text,
            $quickReply,
            $attachments
        );
    }
}
