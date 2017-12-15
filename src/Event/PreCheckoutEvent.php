<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\PreCheckout;

class PreCheckoutEvent extends AbstractEvent
{
    const NAME = 'pre_checkout';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\PreCheckout
     */
    protected $preCheckout;

    /**
     * PaymentEvent constructor.
     *
     * @param string                                      $senderId
     * @param string                                      $recipientId
     * @param int                                         $timestamp
     * @param \Kerox\Messenger\Model\Callback\PreCheckout $preCheckout
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, PreCheckout $preCheckout)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->preCheckout = $preCheckout;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\PreCheckout
     */
    public function getPreCheckout(): PreCheckout
    {
        return $this->preCheckout;
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
     * @return \Kerox\Messenger\Event\PreCheckoutEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $payment = PreCheckout::create($payload['pre_checkout']);

        return new static($senderId, $recipientId, $timestamp, $payment);
    }
}
