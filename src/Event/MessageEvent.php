<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Message;

class MessageEvent extends AbstractEvent
{
    public const NAME = 'message';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Message
     */
    protected $message;

    /**
     * MessageEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Message $message)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->message = $message;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function isQuickReply(): bool
    {
        return $this->message->hasQuickReply();
    }

    /**
     * @return \Kerox\Messenger\Event\MessageEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $message = Message::create($payload['message']);

        return new static($senderId, $recipientId, $timestamp, $message);
    }
}
