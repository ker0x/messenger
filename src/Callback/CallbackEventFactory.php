<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Read;

class CallbackEventFactory
{

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\AbstractCallbackEvent
     */
    public static function create(array $payload): AbstractCallbackEvent
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

        return self::createRawEvent($payload);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\RawEvent
     */
    public static function createRawEvent(array $payload): RawEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        unset($payload['sender'], $payload['recipient'], $payload['timestamp']);

        return new RawEvent($senderId, $recipientId, $timestamp, $payload);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\MessageEchoEvent
     */
    public static function createMessageEchoEvent(array $payload): MessageEchoEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $messageEcho = MessageEcho::create($payload);

        return new MessageEchoEvent($senderId, $recipientId, $timestamp, $messageEcho);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\MessageEvent
     */
    public static function createMessageEvent(array $payload): MessageEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $message = Message::create($payload);

        return new MessageEvent($senderId, $recipientId, $timestamp, $message);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\PostbackEvent
     */
    public static function createPostbackEvent(array $payload): PostbackEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $postback = Postback::create($payload);

        return new PostbackEvent($senderId, $recipientId, $timestamp, $postback);
    }

    /**
     * @param array $payload
     * @return \Kerox\Messenger\Callback\OptinEvent
     */
    public static function createOptinEvent(array $payload): OptinEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $optin = Optin::create($payload);

        return new OptinEvent($senderId, $recipientId, $timestamp, $optin);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Callback\AccountLinkingEvent
     */
    public static function createAcountLinkingEvent($payload): AccountLinkingEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $accountLinking = AccountLinking::create($payload);

        return new AccountLinkingEvent($senderId, $recipientId, $timestamp, $accountLinking);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Callback\DeliveryEvent
     */
    public static function createDeliveryEvent($payload): DeliveryEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $delivery = Delivery::create($payload);

        return new DeliveryEvent($senderId, $recipientId, $timestamp, $delivery);
    }

    /**
     * @param $payload
     * @return \Kerox\Messenger\Callback\ReadEvent
     */
    public static function createReadEvent($payload): ReadEvent
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $read = Read::create($payload);

        return new ReadEvent($senderId, $recipientId, $timestamp, $read);
    }
}
