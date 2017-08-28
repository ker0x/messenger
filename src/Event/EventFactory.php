<?php

namespace Kerox\Messenger\Event;

class EventFactory
{
    const EVENTS = [
        'message'             => MessageEvent::class,
        'postback'            => PostbackEvent::class,
        'optin'               => OptinEvent::class,
        'account_linking'     => AccountLinkingEvent::class,
        'delivery'            => DeliveryEvent::class,
        'read'                => ReadEvent::class,
        'payment'             => PaymentEvent::class,
        'checkout_update'     => CheckoutUpdateEvent::class,
        'pre_checkout'        => PreCheckoutEvent::class,
        'take_thread_control' => TakeThreadControlEvent::class,
        'pass_thread_control' => PassThreadControlEvent::class,
        'policy-enforcement'  => PolicyEnforcementEvent::class,
        'app_roles'           => AppRolesEvent::class,
    ];

    /**
     * @param array $payload
     *
     * @return \Kerox\Messenger\Event\AbstractEvent
     */
    public static function create(array $payload): AbstractEvent
    {
        foreach (array_keys($payload) as $key) {
            if (array_key_exists($key, self::EVENTS)) {
                $className = self::EVENTS[$key];
                if (isset($payload['message']['is_echo'])) {
                    $className = MessageEchoEvent::class;
                }

                return $className::create($payload);
            }
        }

        return RawEvent::create($payload);
    }
}
