<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\TakeThreadControl;

class TakeThreadControlEvent extends AbstractEvent
{
    const NAME = 'take_thread_control';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\TakeThreadControl
     */
    protected $takeThreadControl;

    /**
     * TakeThreadControlEvent constructor.
     *
     * @param string                                            $senderId
     * @param string                                            $recipientId
     * @param int                                               $timestamp
     * @param \Kerox\Messenger\Model\Callback\TakeThreadControl $takeThreadControl
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, TakeThreadControl $takeThreadControl)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->takeThreadControl = $takeThreadControl;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\TakeThreadControl
     */
    public function getTakeThreadControl(): TakeThreadControl
    {
        return $this->takeThreadControl;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param array $payload
     *
     * @return \Kerox\Messenger\Event\TakeThreadControlEvent
     */
    public static function create(array $payload): TakeThreadControlEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $takeThreadControl = TakeThreadControl::create($payload['take_thread_control']);

        return new static($senderId, $recipientId, $timestamp, $takeThreadControl);
    }
}
