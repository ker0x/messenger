<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Payment;

class PaymentEvent extends AbstractEvent
{
    public const NAME = 'payment';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Payment
     */
    protected $payment;

    /**
     * PaymentEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Payment $payment)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->payment = $payment;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\PaymentEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $payment = Payment::create($payload['payment']);

        return new static($senderId, $recipientId, $timestamp, $payment);
    }
}
