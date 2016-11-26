<?php
namespace Kerox\Messenger\Callback;

abstract class AbstractCallbackEvent
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
     * @var int
     */
    protected $timestamp;

    /**
     * AbstractCallbackEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->timestamp = $timestamp;
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
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}