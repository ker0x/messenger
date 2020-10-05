<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Event;

use Kerox\Messenger\Event\AccountLinkingEvent;
use Kerox\Messenger\Event\AppRolesEvent;
use Kerox\Messenger\Event\CheckoutUpdateEvent;
use Kerox\Messenger\Event\DeliveryEvent;
use Kerox\Messenger\Event\EventFactory;
use Kerox\Messenger\Event\GamePlayEvent;
use Kerox\Messenger\Event\MessageEchoEvent;
use Kerox\Messenger\Event\MessageEvent;
use Kerox\Messenger\Event\OptinEvent;
use Kerox\Messenger\Event\PassThreadControlEvent;
use Kerox\Messenger\Event\PaymentEvent;
use Kerox\Messenger\Event\PolicyEnforcementEvent;
use Kerox\Messenger\Event\PostbackEvent;
use Kerox\Messenger\Event\PreCheckoutEvent;
use Kerox\Messenger\Event\RawEvent;
use Kerox\Messenger\Event\ReactionEvent;
use Kerox\Messenger\Event\ReadEvent;
use Kerox\Messenger\Event\ReferralEvent;
use Kerox\Messenger\Event\RequestThreadControlEvent;
use Kerox\Messenger\Event\TakeThreadControlEvent;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\AppRoles;
use Kerox\Messenger\Model\Callback\CheckoutUpdate;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\GamePlay;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\PassThreadControl;
use Kerox\Messenger\Model\Callback\Payment;
use Kerox\Messenger\Model\Callback\Payment\PaymentCredential;
use Kerox\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Kerox\Messenger\Model\Callback\PolicyEnforcement;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\PreCheckout;
use Kerox\Messenger\Model\Callback\Reaction;
use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Model\Callback\Referral;
use Kerox\Messenger\Model\Callback\RequestThreadControl;
use Kerox\Messenger\Model\Callback\TakeThreadControl;
use Kerox\Messenger\Model\Common\Address;
use PHPUnit\Framework\TestCase;

class EventFactoryTest extends TestCase
{
    public function testRawEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/raw.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new RawEvent('USER_ID', 'PAGE_ID', ['timestamp' => 1458692752478, 'speech' => ['mid' => 'mid.1457764197618:41d102a3e1ae206a38', 'seq' => 73]]);
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);
    }

    public function testEntryEvent(): void
    {

    }

    public function testMessageEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/message.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, Message::create($array['message']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $message = $event->getMessage();
        self::assertSame('mid.1457764197618:41d102a3e1ae206a38', $message->getMessageId());
        self::assertTrue($message->hasText());
        self::assertSame('hello, world!', $message->getText());
        self::assertTrue($message->hasQuickReply());
        self::assertSame('DEVELOPER_DEFINED_PAYLOAD', $message->getQuickReply());
        self::assertTrue($message->hasAttachments());
        self::assertSame([['type' => 'image', 'payload' => ['url' => 'IMAGE_URL']]], $message->getAttachments());
        self::assertTrue($message->hasEntities());
        self::assertSame([
            'datetime' => [
                ['confidence' => 0.97249440664957, 'values' => ['...'], 'value' => '2017-05-10T14:00:00.000-07:00', 'grain' => 'hour', 'type' => 'value']
            ],
            'greetings' => [
                ['confidence' => 1, 'value' => 'true']
            ]
        ], $message->getEntities());
    }

    public function testMessageEchoEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/message_echo.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new MessageEchoEvent('USER_ID', 'PAGE_ID', 1457764197627, MessageEcho::create($array['message']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $messageEcho = $event->getMessageEcho();
        self::assertTrue($messageEcho->isEcho());
        self::assertSame(1517776481860111, $messageEcho->getAppId());
        self::assertSame('DEVELOPER_DEFINED_METADATA_STRING', $messageEcho->getMetadata());
        self::assertSame('mid.1457764197618:41d102a3e1ae206a38', $messageEcho->getMessageId());
    }

    public function testPostbackEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/postback.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PostbackEvent('USER_ID', 'PAGE_ID', 1458692752478, Postback::create($array['postback']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $postback = $event->getPostback();
        self::assertSame('TITLE_FOR_THE_CTA', $postback->getTitle());
        self::assertTrue($postback->hasPayload());
        self::assertSame('USER_DEFINED_PAYLOAD', $postback->getPayload());
        self::assertTrue($postback->hasReferral());
        self::assertInstanceOf(Referral::class, $postback->getReferral());
    }

    public function testPostbackEventFromStandBy(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/postback_from_stand_by.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PostbackEvent('USER_ID', 'PAGE_ID', 1458692752478, Postback::create($array['postback']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $postback = $event->getPostback();
        self::assertSame('TITLE_FOR_THE_CTA', $postback->getTitle());
        self::assertFalse($postback->hasPayload());
        self::assertNull($postback->getPayload());
        self::assertFalse($postback->hasReferral());
        self::assertNull($postback->getReferral());
    }

    public function testOptinEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/optin.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new OptinEvent('USER_ID', 'PAGE_ID', 1234567890, Optin::create($array['optin']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $optin = $event->getOptin();
        self::assertSame('PASS_THROUGH_PARAM', $optin->getRef());
    }

    public function testAccountLinkingEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/account_linking.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new AccountLinkingEvent('USER_ID', 'PAGE_ID', 1234567890, AccountLinking::create($array['account_linking']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $accountLinking = $event->getAccountLinking();
        self::assertSame('linked', $accountLinking->getStatus());
        self::assertTrue($accountLinking->hasAuthorizationCode());
        self::assertSame('PASS_THROUGH_AUTHORIZATION_CODE', $accountLinking->getAuthorizationCode());
    }

    public function testDeliveryEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/delivery.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new DeliveryEvent('USER_ID', 'PAGE_ID', Delivery::create($array['delivery']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $delivery = $event->getDelivery();
        self::assertSame(1458668856253, $delivery->getWatermark());
        self::assertSame(['mid.1458668856218:ed81099e15d3f4f233'], $delivery->getMessageIds());
    }

    public function testReadEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/read.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new ReadEvent('USER_ID', 'PAGE_ID', 1458668856463, Read::create($array['read']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $read = $event->getRead();
        self::assertSame(1458668856253, $read->getWatermark());
    }

    public function testPaymentEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/payment.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PaymentEvent('USER_ID', 'PAGE_ID', 1473208792799, Payment::create($array['payment']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $payment = $event->getPayment();
        self::assertSame('DEVELOPER_DEFINED_PAYLOAD', $payment->getPayload());
        self::assertSame('123', $payment->getShippingOptionId());
        self::assertSame('USD', $payment->getCurrency());
        self::assertSame('29.62', $payment->getAmount());
        self::assertInstanceOf(RequestedUserInfo::class, $payment->getRequestedUserInfo());
        self::assertInstanceOf(PaymentCredential::class, $payment->getPaymentCredential());
        self::assertInstanceOf(Address::class, $payment->getShippingAddress());

        $requestedUserInfo = $payment->getRequestedUserInfo();
        self::assertSame('Peter Chang', $requestedUserInfo->getContactName());
        self::assertSame('peter@anemailprovider.com', $requestedUserInfo->getContactEmail());
        self::assertSame('+15105551234', $requestedUserInfo->getContactPhone());

        $paymentCredential = $payment->getPaymentCredential();
        self::assertSame('token', $paymentCredential->getProviderType());
        self::assertSame('ch_18tmdBEoNIH3FPJHa60ep123', $paymentCredential->getChargeId());
        self::assertSame('__tokenized_card__', $paymentCredential->getTokenizedCard());
        self::assertSame('tokenized cvv', $paymentCredential->getTokenizedCvv());
        self::assertSame('3', $paymentCredential->getTokenExpiryMonth());
        self::assertSame('2019', $paymentCredential->getTokenExpiryYear());
        self::assertSame('123456789', $paymentCredential->getFbPaymentId());

        $shippingAddress = $payment->getShippingAddress();
        self::assertSame('1 Hacker Way', $shippingAddress->getStreet());
        self::assertSame('', $shippingAddress->getAdditionalStreet());
        self::assertSame('MENLO PARK', $shippingAddress->getCity());
        self::assertSame('CA', $shippingAddress->getState());
        self::assertSame('US', $shippingAddress->getCountry());
        self::assertSame('94025', $shippingAddress->getPostalCode());
    }

    public function testCheckoutUpdateEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/checkout_update.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new CheckoutUpdateEvent('USER_ID', 'PAGE_ID', 1473204787206, CheckoutUpdate::create($array['checkout_update']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $checkoutUpdate = $event->getCheckoutUpdate();
        self::assertSame('DEVELOPER_DEFINED_PAYLOAD', $checkoutUpdate->getPayload());
        self::assertInstanceOf(Address::class, $checkoutUpdate->getShippingAddress());

        $shippingAddress = $checkoutUpdate->getShippingAddress();
        self::assertSame('1 Hacker Way', $shippingAddress->getStreet());
        self::assertSame('', $shippingAddress->getAdditionalStreet());
        self::assertSame('MENLO PARK', $shippingAddress->getCity());
        self::assertSame('CA', $shippingAddress->getState());
        self::assertSame('US', $shippingAddress->getCountry());
        self::assertSame('94025', $shippingAddress->getPostalCode());
        self::assertSame(10105655000959552, $shippingAddress->getId());
    }

    public function testPreCheckoutEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/pre_checkout.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PreCheckoutEvent('USER_ID', 'PAGE_ID', 1473208792799, PreCheckout::create($array['pre_checkout']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $preCheckout = $event->getPreCheckout();
        self::assertSame('DEVELOPER_DEFINED_PAYLOAD', $preCheckout->getPayload());
        self::assertSame('USD', $preCheckout->getCurrency());
        self::assertSame('29.62', $preCheckout->getAmount());
        self::assertInstanceOf(RequestedUserInfo::class, $preCheckout->getRequestedUserInfo());
        self::assertInstanceOf(Address::class, $preCheckout->getShippingAddress());

        $requestedUserInfo = $preCheckout->getRequestedUserInfo();
        self::assertSame('Peter Chang', $requestedUserInfo->getContactName());

        $shippingAddress = $preCheckout->getShippingAddress();
        self::assertSame('Peter Chang', $shippingAddress->getName());
        self::assertSame('1 Hacker Way', $shippingAddress->getStreet());
        self::assertSame('', $shippingAddress->getAdditionalStreet());
        self::assertSame('MENLO PARK', $shippingAddress->getCity());
        self::assertSame('CA', $shippingAddress->getState());
        self::assertSame('US', $shippingAddress->getCountry());
        self::assertSame('94025', $shippingAddress->getPostalCode());
    }

    public function testTakeThreadControlEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/take_thread_control.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new TakeThreadControlEvent('USER_ID', 'PAGE_ID', 1458692752478, TakeThreadControl::create($array['take_thread_control']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $takeThreadControl = $event->getTakeThreadControl();
        self::assertSame(123456789, $takeThreadControl->getPreviousOwnerAppId());
        self::assertSame('additional content that the caller wants to set', $takeThreadControl->getMetadata());
    }

    public function testPassThreadControlEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/pass_thread_control.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PassThreadControlEvent('USER_ID', 'PAGE_ID', 1458692752478, PassThreadControl::create($array['pass_thread_control']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $passThreadControl = $event->getPassThreadControl();
        self::assertSame(123456789, $passThreadControl->getNewOwnerAppId());
        self::assertSame('additional content that the caller wants to set', $passThreadControl->getMetadata());
    }

    public function testRequestThreadControlEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/request_thread_control.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new RequestThreadControlEvent('USER_ID', 'PSID', 1458692752478, RequestThreadControl::create($array['request_thread_control']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $requestThreadControl = $event->getRequestThreadControl();
        self::assertSame(123456789, $requestThreadControl->getRequestedOwnerAppId());
        self::assertSame('additional content that the caller wants to set', $requestThreadControl->getMetadata());
    }

    public function testPolicyEnforcementEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/policy_enforcement.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new PolicyEnforcementEvent('', 'PAGE_ID', 1458692752478, PolicyEnforcement::create($array['policy-enforcement']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $policyEnforcement = $event->getPolicyEnforcement();
        self::assertSame('block', $policyEnforcement->getAction());
        self::assertSame('The bot violated our Platform Policies (https://developers.facebook.com/policy/#messengerplatform). Common violations include sending out excessive spammy messages or being non-functional.', $policyEnforcement->getReason());

    }

    public function testAppRolesEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/app_roles.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new AppRolesEvent('', 'PAGE_ID', 1458692752478, AppRoles::create($array['app_roles']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $appRoles = $event->getAppRoles();
        self::assertSame(['123456789' => ['automation']], $appRoles->getAppRoles());
    }

    public function testReferralEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/referral.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new ReferralEvent('USER_ID', 'PAGE_ID', 1458692752478, Referral::create($array['referral']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $referral = $event->getReferral();
        self::assertSame('REF DATA PASSED IN M.ME PARAM', $referral->getRef());
        self::assertSame('SHORTLINK', $referral->getSource());
        self::assertSame('OPEN_THREAD', $referral->getType());
    }

    public function testGamePlayEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/game_play.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new GamePlayEvent('USER_ID', 'PAGE_ID', 1458692752478, GamePlay::create($array['game_play']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $gamePlay = $event->getGamePlay();
        self::assertSame('1234', $gamePlay->getGameId());
        self::assertSame('666', $gamePlay->getPlayerId());
        self::assertSame('SOLO|THREAD', $gamePlay->getContextType());
        self::assertSame('123', $gamePlay->getContextId());
        self::assertSame(1234567890, $gamePlay->getScore());
        self::assertSame('DEVELOPER_DEFINED_PAYLOAD', $gamePlay->getPayload());
    }

    public function testReactionEvent(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Event/reaction.json');
        $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $expectedEvent = new ReactionEvent('USER_ID', 'PAGE_ID', 1458668856463, Reaction::create($array['reaction']));
        $event = EventFactory::create($array);

        self::assertEquals($expectedEvent, $event);

        $reaction = $event->getReaction();
        self::assertSame('smile', $reaction->getReaction());
        self::assertSame("❤️", $reaction->getEmoji());
        self::assertSame('react', $reaction->getAction());
        self::assertSame('<MID>', $reaction->getMid());
    }
}
