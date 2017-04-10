<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Read;

class ReadEvent extends AbstractEvent
{

    const NAME = 'read';

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
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Read $read
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Read $read)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->read = $read;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Read
     */
    public function getRead(): Read
    {
        return $this->read;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Event\ReadEvent
     */
    public static function create(array $payload): ReadEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $read = Read::create($payload['read']);

        return new static($senderId, $recipientId, $timestamp, $read);
    }
}
