<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\PreCheckout;

class PreCheckoutEvent extends AbstractEvent
{
    public const NAME = 'pre_checkout';

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
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, PreCheckout $preCheckout)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->preCheckout = $preCheckout;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getPreCheckout(): PreCheckout
    {
        return $this->preCheckout;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
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
