<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Payment;

class PaymentEvent extends AbstractEvent
{

    const NAME = 'payment';

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
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Payment $payment
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Payment $payment)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->payment = $payment;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Payment
     */
    public function getPayment(): Payment
    {
        return $this->payment;
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
     * @return \Kerox\Messenger\Event\PaymentEvent
     */
    public static function create(array $payload): PaymentEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $payment = Payment::create($payload['payment']);

        return new static($senderId, $recipientId, $timestamp, $payment);
    }
}
