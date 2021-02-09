<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\RequestThreadControl;

final class RequestThreadControlEvent extends AbstractEvent
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

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getRequestThreadControl(): RequestThreadControl
    {
        return $this->requestThreadControl;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\RequestThreadControlEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $requestThreadControl = RequestThreadControl::create($payload['request_thread_control']);

        return new self($senderId, $recipientId, $timestamp, $requestThreadControl);
    }
}
