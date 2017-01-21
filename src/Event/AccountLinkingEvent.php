<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AccountLinking;

class AccountLinkingEvent extends AbstractEvent
{

    const NAME = 'account_linking';

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Event\AccountLinkingEvent
     */
    public static function create(array $payload): AccountLinkingEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $accountLinking = AccountLinking::create($payload['account_linking']);

        return new static($senderId, $recipientId, $timestamp, $accountLinking);
    }
}
