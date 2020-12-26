<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AccountLinking;

final class AccountLinkingEvent extends AbstractEvent
{
    public const NAME = 'account_linking';

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
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, AccountLinking $accountLinking)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->accountLinking = $accountLinking;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getAccountLinking(): AccountLinking
    {
        return $this->accountLinking;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\AccountLinkingEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $accountLinking = AccountLinking::create($payload['account_linking']);

        return new static($senderId, $recipientId, $timestamp, $accountLinking);
    }
}
