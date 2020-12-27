<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Read;

final class ReadEvent extends AbstractEvent
{
    public const NAME = 'read';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Read
     */
    protected $read;

    /**
     * ReadEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Read $read)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->read = $read;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getRead(): Read
    {
        return $this->read;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\ReadEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $read = Read::create($payload['read']);

        return new static($senderId, $recipientId, $timestamp, $read);
    }
}
