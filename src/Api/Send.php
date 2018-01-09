<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;

class Send extends AbstractApi
{
    use ValidatorTrait;

    public const SENDER_ACTION_TYPING_ON = 'typing_on';
    public const SENDER_ACTION_TYPING_OFF = 'typing_off';
    public const SENDER_ACTION_MARK_SEEN = 'mark_seen';

    public const NOTIFICATION_TYPE_REGULAR = 'REGULAR';
    public const NOTIFICATION_TYPE_SILENT_PUSH = 'SILENT_PUSH';
    public const NOTIFICATION_TYPE_NO_PUSH = 'NO_PUSH';

    public const TAG_SHIPPING_UPDATE = 'SHIPPING_UPDATE';
    public const TAG_RESERVATION_UPDATE = 'RESERVATION_UPDATE';
    public const TAG_ISSUE_RESOLUTION = 'ISSUE_RESOLUTION';
    public const TAG_APPOINTMENT_UPDATE = 'APPOINTMENT_UPDATE';
    public const TAG_GAME_EVENT = 'GAME_EVENT';
    public const TAG_TRANSPORTATION_UPDATE = 'TRANSPORTATION_UPDATE';
    public const TAG_FEATURE_FUNCTIONALITY_UPDATE = 'FEATURE_FUNCTIONALITY_UPDATE';
    public const TAG_TICKET_UPDATE = 'TICKET_UPDATE';
    public const TAG_ACCOUNT_UPDATE = 'ACCOUNT_UPDATE';
    public const TAG_PAYMENT_UPDATE = 'PAYMENT_UPDATE';
    public const TAG_PERSONAL_FINANCE_UPDATE = 'PERSONAL_FINANCE_UPDATE';

    /**
     * @var null|\Kerox\Messenger\Api\Send
     */
    private static $_instance;

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Send
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param string                                $recipient
     * @param string|\Kerox\Messenger\Model\Message $message
     * @param string                                $notificationType
     * @param string|null                           $tag
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function message(
        string $recipient,
        $message,
        string $notificationType = self::NOTIFICATION_TYPE_REGULAR,
        ?string $tag = null
    ): SendResponse {
        $message = $this->isValidMessage($message);
        $this->isValidNotificationType($notificationType, $this->getAllowedNotificationType());

        if ($tag !== null) {
            $this->isValidTag($tag, $this->getAllowedTag());
        }

        $request = new SendRequest($this->pageToken, $message, $recipient, $notificationType, $tag);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param string $recipient
     * @param string $action
     * @param string $notificationType
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(
        string $recipient,
        string $action,
        string $notificationType = self::NOTIFICATION_TYPE_REGULAR
    ): SendResponse {
        $this->isValidAction($action);
        $this->isValidNotificationType($notificationType, $this->getAllowedNotificationType());

        $request = new SendRequest($this->pageToken, $action, $recipient, $notificationType, null, SendRequest::REQUEST_TYPE_ACTION);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\Message\Attachment $attachment
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function attachment(Attachment $attachment): SendResponse
    {
        $message = $this->isValidMessage($attachment);

        $request = new SendRequest($this->pageToken, $message);
        $response = $this->client->post('me/message_attachments', $request->build());

        return new SendResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedNotificationType(): array
    {
        return [
            self::NOTIFICATION_TYPE_REGULAR,
            self::NOTIFICATION_TYPE_SILENT_PUSH,
            self::NOTIFICATION_TYPE_NO_PUSH,
        ];
    }

    /**
     * @param string $action
     *
     * @throws \InvalidArgumentException
     */
    private function isValidAction(string $action): void
    {
        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!\in_array($action, $allowedSenderAction, true)) {
            throw new \InvalidArgumentException('$action must be either ' . implode(', ', $allowedSenderAction));
        }
    }

    /**
     * @return array
     */
    private function getAllowedSenderAction(): array
    {
        return [
            self::SENDER_ACTION_TYPING_ON,
            self::SENDER_ACTION_TYPING_OFF,
            self::SENDER_ACTION_MARK_SEEN,
        ];
    }

    /**
     * @return array
     */
    private function getAllowedTag(): array
    {
        return [
            self::TAG_ISSUE_RESOLUTION,
            self::TAG_RESERVATION_UPDATE,
            self::TAG_SHIPPING_UPDATE,
            self::TAG_APPOINTMENT_UPDATE,
            self::TAG_GAME_EVENT,
            self::TAG_TRANSPORTATION_UPDATE,
            self::TAG_FEATURE_FUNCTIONALITY_UPDATE,
            self::TAG_TICKET_UPDATE,
            self::TAG_ACCOUNT_UPDATE,
            self::TAG_PAYMENT_UPDATE,
            self::TAG_PERSONAL_FINANCE_UPDATE,
        ];
    }
}
