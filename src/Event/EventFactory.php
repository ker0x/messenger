<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

class EventFactory
{
    public const EVENTS = [
        'message' => MessageEvent::class,
        'postback' => PostbackEvent::class,
        'optin' => OptinEvent::class,
        'account_linking' => AccountLinkingEvent::class,
        'delivery' => DeliveryEvent::class,
        'read' => ReadEvent::class,
        'payment' => PaymentEvent::class,
        'checkout_update' => CheckoutUpdateEvent::class,
        'pre_checkout' => PreCheckoutEvent::class,
        'take_thread_control' => TakeThreadControlEvent::class,
        'pass_thread_control' => PassThreadControlEvent::class,
        'request_thread_control' => RequestThreadControlEvent::class,
        'policy-enforcement' => PolicyEnforcementEvent::class,
        'app_roles' => AppRolesEvent::class,
        'referral' => ReferralEvent::class,
        'game_play' => GamePlayEvent::class,
        'reaction' => ReactionEvent::class,
    ];

    /**
     * @return \Kerox\Messenger\Event\AbstractEvent
     */
    public static function create(array $payload): AbstractEvent
    {
        foreach (array_keys($payload) as $key) {
            if (\array_key_exists($key, self::EVENTS)) {
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
