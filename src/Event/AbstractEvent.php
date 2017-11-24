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
     *
     * @param string $senderId
     * @param string $recipientId
     */
    public function __construct(string $senderId, string $recipientId)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
    }

    /**
     * @return string
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * @return string
     */
    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param array $payload
     *
     * @return mixed
     */
    abstract public static function create(array $payload);
}
