<?php

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
     *
     * @param string                                  $senderId
     * @param string                                  $recipientId
     * @param int                                     $timestamp
     * @param \Kerox\Messenger\Model\Callback\Message $message
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Message $message)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return bool
     */
    public function isQuickReply(): bool
    {
        return $this->message->hasQuickReply();
    }

    /**
     * @param array $payload
     *
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
