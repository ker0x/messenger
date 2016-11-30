<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Optin;

class OptinEvent extends AbstractEvent
{

    const NAME = 'optin';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Optin
     */
    protected $optin;

    /**
     * OptinEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Optin $optin
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Optin $optin)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->optin = $optin;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Optin
     */
    public function getOptin(): Optin
    {
        return $this->optin;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
