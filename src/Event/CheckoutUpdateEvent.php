<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\CheckoutUpdate;

final class CheckoutUpdateEvent extends AbstractEvent
{
    public const NAME = 'checkout_update';

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
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, CheckoutUpdate $checkoutUpdate)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->checkoutUpdate = $checkoutUpdate;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getCheckoutUpdate(): CheckoutUpdate
    {
        return $this->checkoutUpdate;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\CheckoutUpdateEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $checkoutUpdate = CheckoutUpdate::create($payload['checkout_update']);

        return new self($senderId, $recipientId, $timestamp, $checkoutUpdate);
    }
}
