<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

abstract class AbstractEvent
{
    /**
     * @var string
     */
    protected $senderId;

    /**
     * @var string
     */
    protected $recipientId;

    /**
     * AbstractCallbackEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    abstract public function getName(): string;

    /**
     * @return mixed
     */
    abstract public static function create(array $payload);
}
