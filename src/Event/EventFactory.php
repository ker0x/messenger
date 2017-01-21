<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\CheckoutUpdate;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Read;

class EventFactory
{

    use UtilityTrait;

    const EVENTS = [
        'message',
        'postback',
        'optin',
        'account_linking',
        'delivery',
        'read',
        'payment',
        'checkout_update',
    ];

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\AbstractEvent
     */
    public static function create(array $payload): AbstractEvent
    {
        foreach (array_keys($payload) as $key) {
            if (in_array($key, self::EVENTS)) {
                $eventName = UtilityTrait::camelize($key);
                $functionName = 'create' . $eventName . 'Event';

                return self::$functionName($payload);
            }
        }

        return self::createRawEvent($payload);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\RawEvent
     */
    public static function createRawEvent(array $payload): RawEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        unset($payload['sender'], $payload['recipient']);

        return new RawEvent($senderId, $recipientId, $payload);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\MessageEvent|\Kerox\Messenger\Event\MessageEchoEvent
     */
    public static function createMessageEvent(array $payload)
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];

        $message = Message::create($payload['message']);
        if (isset($payload['message']['is_echo'])) {
            $message = MessageEcho::create($payload['message']);

            return new MessageEchoEvent($senderId, $recipientId, $timestamp, $message);
        }

        return new MessageEvent($senderId, $recipientId, $timestamp, $message);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\PostbackEvent
     */
    public static function createPostbackEvent(array $payload): PostbackEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $postback = Postback::create($payload['postback']);

        return new PostbackEvent($senderId, $recipientId, $timestamp, $postback);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\OptinEvent
     */
    public static function createOptinEvent(array $payload): OptinEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $optin = Optin::create($payload['optin']);

        return new OptinEvent($senderId, $recipientId, $timestamp, $optin);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Event\AccountLinkingEvent
     */
    public static function createAccountLinkingEvent(array $payload): AccountLinkingEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $accountLinking = AccountLinking::create($payload['account_linking']);

        return new AccountLinkingEvent($senderId, $recipientId, $timestamp, $accountLinking);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Event\DeliveryEvent
     */
    public static function createDeliveryEvent(array $payload): DeliveryEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $delivery = Delivery::create($payload['delivery']);

        return new DeliveryEvent($senderId, $recipientId, $delivery);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Event\ReadEvent
     */
    public static function createReadEvent($payload): ReadEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $read = Read::create($payload['read']);

        return new ReadEvent($senderId, $recipientId, $timestamp, $read);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\PaymentEvent
     */
    public static function createPaymentEvent(array $payload): PaymentEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $payment = Payment::create($payload['payment']);

        return new PaymentEvent($senderId, $recipientId, $timestamp, $payment);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\CheckoutUpdateEvent
     */
    public static function createCheckoutUpdateEvent(array $payload)
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $checkoutUpdate = CheckoutUpdate::create($payload['checkout_update']);

        return new CheckoutUpdateEvent($senderId, $recipientId, $timestamp, $checkoutUpdate);
    }
}
