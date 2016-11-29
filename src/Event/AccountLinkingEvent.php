<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AccountLinking;

class AccountLinkingEvent extends AbstractEvent
{

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\AccountLinking
     */
    protected $accountLinking;

    /**
     * AccountLinkingEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\AccountLinking $accountLinking
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, AccountLinking $accountLinking)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->accountLinking = $accountLinking;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\AccountLinking
     */
    public function getAccountLinking(): AccountLinking
    {
        return $this->accountLinking;
    }
}
