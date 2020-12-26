<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\PassThreadControl;

final class PassThreadControlEvent extends AbstractEvent
{
    public const NAME = 'pass_thread_control';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    protected $passThreadControl;

    /**
     * PassThreadControlEvent constructor.
     */
    public function __construct(
        string $senderId,
        string $recipientId,
        int $timestamp,
        PassThreadControl $passThreadControl
    ) {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->passThreadControl = $passThreadControl;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getPassThreadControl(): PassThreadControl
    {
        return $this->passThreadControl;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\PassThreadControlEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $passThreadControl = PassThreadControl::create($payload['pass_thread_control']);

        return new static($senderId, $recipientId, $timestamp, $passThreadControl);
    }
}
