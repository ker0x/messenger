<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\RequestThreadControl;

class RequestThreadControlEvent extends AbstractEvent
{
    public const NAME = 'request_thread_control';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\RequestThreadControl
     */
    protected $requestThreadControl;

    /**
     * TakeThreadControlEvent constructor.
     *
     * @param string                                               $senderId
     * @param string                                               $recipientId
     * @param int                                                  $timestamp
     * @param \Kerox\Messenger\Model\Callback\RequestThreadControl $requestThreadControl
     */
    public function __construct(
        string $senderId,
        string $recipientId,
        int $timestamp,
        RequestThreadControl $requestThreadControl
    ) {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->requestThreadControl = $requestThreadControl;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\RequestThreadControl
     */
    public function getTakeThreadControl(): RequestThreadControl
    {
        return $this->requestThreadControl;
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
     * @return \Kerox\Messenger\Event\RequestThreadControlEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $requestThreadControl = RequestThreadControl::create($payload['request_thread_control']);

        return new static($senderId, $recipientId, $timestamp, $requestThreadControl);
    }
}
