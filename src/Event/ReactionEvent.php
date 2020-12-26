<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Reaction;

final class ReactionEvent extends AbstractEvent
{
    public const NAME = 'reaction';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Reaction
     */
    protected $reaction;

    public function __construct(string $senderId, string $recipientId, int $timestamp, Reaction $reaction)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->reaction = $reaction;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getReaction(): Reaction
    {
        return $this->reaction;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\ReactionEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $reaction = Reaction::create($payload['reaction']);

        return new static($senderId, $recipientId, $timestamp, $reaction);
    }
}
