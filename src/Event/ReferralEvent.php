<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Referral;

class ReferralEvent extends AbstractEvent
{
    public const NAME = 'referral';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Referral
     */
    protected $referral;

    /**
     * ReferralEvent constructor.
     *
     * @param string                                   $senderId
     * @param string                                   $recipientId
     * @param int                                      $timestamp
     * @param \Kerox\Messenger\Model\Callback\Referral $referral
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Referral $referral)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->referral = $referral;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Referral
     */
    public function getReferral(): Referral
    {
        return $this->referral;
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
     * @return \Kerox\Messenger\Event\ReferralEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $referral = Referral::create($payload['referral']);

        return new static($senderId, $recipientId, $timestamp, $referral);
    }
}
