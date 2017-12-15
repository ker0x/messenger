<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\CheckoutUpdate;

class CheckoutUpdateEvent extends AbstractEvent
{
    const NAME = 'checkout_update';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\CheckoutUpdate
     */
    protected $checkoutUpdate;

    /**
     * CheckoutUpdateEvent constructor.
     *
     * @param string                                         $senderId
     * @param string                                         $recipientId
     * @param int                                            $timestamp
     * @param \Kerox\Messenger\Model\Callback\CheckoutUpdate $checkoutUpdate
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, CheckoutUpdate $checkoutUpdate)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->checkoutUpdate = $checkoutUpdate;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\CheckoutUpdate
     */
    public function getCheckoutUpdate(): CheckoutUpdate
    {
        return $this->checkoutUpdate;
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
     * @return \Kerox\Messenger\Event\CheckoutUpdateEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $checkoutUpdate = CheckoutUpdate::create($payload['checkout_update']);

        return new static($senderId, $recipientId, $timestamp, $checkoutUpdate);
    }
}
