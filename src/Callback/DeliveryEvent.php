<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\Delivery;

class DeliveryEvent extends AbstractCallbackEvent
{

    /**
     * @var \Kerox\Messenger\Model\Callback\Delivery
     */
    protected $delivery;

    /**
     * DeliveryEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
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
}
