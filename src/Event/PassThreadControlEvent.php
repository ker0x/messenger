<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\PassThreadControl;

class PassThreadControlEvent extends AbstractEvent
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
     *
     * @param string                                            $senderId
     * @param string                                            $recipientId
     * @param int                                               $timestamp
     * @param \Kerox\Messenger\Model\Callback\PassThreadControl $passThreadControl
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, PassThreadControl $passThreadControl)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->passThreadControl = $passThreadControl;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\PassThreadControl
     */
    public function getPassThreadControl(): PassThreadControl
    {
        return $this->passThreadControl;
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
