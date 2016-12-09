<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Read;

class EventFactory
{

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\AbstractEvent
     */
    public static function create(array $payload): AbstractEvent
    {
        if (isset($payload['message'])) {
            if (isset($payload['message']['is_echo'])) {
                return self::createMessageEchoEvent($payload);
            }

            return self::createMessageEvent($payload);
        }

        if (isset($payload['postback'])) {
            return self::createPostbackEvent($payload);
        }

        if (isset($payload['optin'])) {
            return self::createOptinEvent($payload);
        }

        if (isset($payload['account_linking'])) {
            return self::createAcountLinkingEvent($payload);
        }

        if (isset($payload['delivery'])) {
            return self::createDeliveryEvent($payload);
        }

        if (isset($payload['read'])) {
            return self::createReadEvent($payload);
        }

        if (isset($payload['payment'])) {
            return self::createPaymentEvent($payload);
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
     * @return \Kerox\Messenger\Event\MessageEchoEvent
     */
    public static function createMessageEchoEvent(array $payload): MessageEchoEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $messageEcho = MessageEcho::create($payload['message']);

        return new MessageEchoEvent($senderId, $recipientId, $timestamp, $messageEcho);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Event\MessageEvent
     */
    public static function createMessageEvent(array $payload): MessageEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $message = Message::create($payload['message']);

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
    public static function createAcountLinkingEvent(array $payload): AccountLinkingEvent
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

    public static function createPaymentEvent(array $payload)
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $payment = Payment::create($payload['payment']);

        return new PaymentEvent($senderId, $recipientId, $timestamp, $payment);
    }
}
