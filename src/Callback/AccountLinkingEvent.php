<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\AccountLinking;

class AccountLinkingEvent extends AbstractCallbackEvent
{

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
    public function __construct($senderId, $recipientId, $timestamp, AccountLinking $accountLinking)
    {
        parent::__construct($senderId, $recipientId, $timestamp);

        $this->accountLinking = $accountLinking;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\AccountLinking
     */
    public function getAccountLinking(): AccountLinking
    {
        return $this->accountLinking;
    }
}