<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Delivery;

class DeliveryEvent extends AbstractEvent
{
    public const NAME = 'delivery';

    /**
     * @var \Kerox\Messenger\Model\Callback\Delivery
     */
    protected $delivery;

    /**
     * DeliveryEvent constructor.
     *
     * @param string                                   $senderId
     * @param string                                   $recipientId
     * @param \Kerox\Messenger\Model\Callback\Delivery $delivery
     */
    public function __construct(string $senderId, string $recipientId, Delivery $delivery)
    {
        parent::__construct($senderId, $recipientId);

        $this->delivery = $delivery;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Delivery
     */
    public function getDelivery(): Delivery
    {
        return $this->delivery;
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
     * @return \Kerox\Messenger\Event\DeliveryEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $delivery = Delivery::create($payload['delivery']);

        return new static($senderId, $recipientId, $delivery);
    }
}
