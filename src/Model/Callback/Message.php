<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Message
{
    /**
     * @var string
     */
    protected $messageId;

    /**
     * @var int
     */
    protected $sequence;

    /**
     * @var string|null
     */
    protected $text;

    /**
     * @var string|null
     */
    protected $quickReply;

    /**
     * @var array
     */
    protected $attachments;

    /**
     * @var array
     */
    protected $entities;

    /**
     * Message constructor.
     *
     * @param string $messageId
     * @param int    $sequence
     * @param string $text
     * @param string $quickReply
     * @param array  $attachments
     * @param array  $entities
     */
    public function __construct(
        string $messageId,
        int $sequence,
        ?string $text = null,
        ?string $quickReply = null,
        array $attachments = [],
        array $entities = []
    ) {
        $this->messageId = $messageId;
        $this->sequence = $sequence;
        $this->text = $text;
        $this->quickReply = $quickReply;
        $this->attachments = $attachments;
        $this->entities = $entities;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @return int
     */
    public function getSequence(): int
    {
        return $this->sequence;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function hasText(): bool
    {
        return $this->text !== null && $this->text !== '';
    }

    /**
     * @return string|null
     */
    public function getQuickReply(): ?string
    {
        return $this->quickReply;
    }

    /**
     * @return bool
     */
    public function hasQuickReply(): bool
    {
        return $this->quickReply !== null && $this->quickReply !== '';
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @return bool
     */
    public function hasAttachments(): bool
    {
        return !empty($this->attachments);
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @return bool
     */
    public function hasEntities(): bool
    {
        return !empty($this->entities);
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\Message
     */
    public static function create(array $callbackData)
    {
        $text = $callbackData['text'] ?? null;
        $quickReply = $callbackData['quick_reply']['payload'] ?? null;
        $attachments = $callbackData['attachments'] ?? [];
        $entities = $callbackData['nlp']['entities'] ?? [];

        return new self($callbackData['mid'], $callbackData['seq'], $text, $quickReply, $attachments, $entities);
    }
}
