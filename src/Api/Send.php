<?php

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;

class Send extends AbstractApi
{
    const SENDER_ACTION_TYPING_ON = 'typing_on';
    const SENDER_ACTION_TYPING_OFF = 'typing_off';
    const SENDER_ACTION_MARK_SEEN = 'mark_seen';

    const NOTIFICATION_TYPE_REGULAR = 'REGULAR';
    const NOTIFICATION_TYPE_SILENT_PUSH = 'SILENT_PUSH';
    const NOTIFICATION_TYPE_NO_PUSH = 'NO_PUSH';

    const TAG_SHIPPING_UPDATE = 'SHIPPING_UPDATE';
    const TAG_RESERVATION_UPDATE = 'RESERVATION_UPDATE';
    const TAG_ISSUE_RESOLUTION = 'ISSUE_RESOLUTION';
    const TAG_APPOINTMENT_UPDATE = 'APPOINTMENT_UPDATE';
    const TAG_GAME_EVENT = 'GAME_EVENT';
    const TAG_TRANSPORTATION_UPDATE = 'TRANSPORTATION_UPDATE';
    const TAG_FEATURE_FUNCTIONALITY_UPDATE = 'FEATURE_FUNCTIONALITY_UPDATE';
    const TAG_TICKET_UPDATE = 'TICKET_UPDATE';
    const TAG_ACCOUNT_UPDATE = 'ACCOUNT_UPDATE';
    const TAG_PAYMENT_UPDATE = 'PAYMENT_UPDATE';
    const TAG_PERSONAL_FINANCE_UPDATE = 'PERSONAL_FINANCE_UPDATE';

    /**
     * @param string                                $recipient
     * @param string|\Kerox\Messenger\Model\Message $message
     * @param string                                $notificationType
     * @param string|null                           $tag
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function message(string $recipient, $message, string $notificationType = self::NOTIFICATION_TYPE_REGULAR, $tag = null): SendResponse
    {
        $message = $this->isValidMessage($message);
        $this->isValidNotificationType($notificationType);

        if ($tag !== null) {
            $this->isValidTag($tag);
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
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(string $recipient, string $action, string $notificationType = self::NOTIFICATION_TYPE_REGULAR): SendResponse
    {
        $this->isValidAction($action);
        $this->isValidNotificationType($notificationType);

        $request = new SendRequest($this->pageToken, $action, $recipient, $notificationType, null, SendRequest::TYPE_ACTION);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\Message\Attachment $attachment
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
     * @param $message
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Message
     */
    private function isValidMessage($message): Message
    {
        if ($message instanceof Message) {
            return $message;
        }

        if (is_string($message) || $message instanceof Attachment) {
            return new Message($message);
        }

        throw new \InvalidArgumentException('$message must be a string or an instance of Message or Attachment');
    }

    /**
     * @param string $notificationType
     *
     * @throws \InvalidArgumentException
     */
    private function isValidNotificationType(string $notificationType)
    {
        $allowedNotificationType = $this->getAllowedNotificationType();
        if (!in_array($notificationType, $allowedNotificationType, true)) {
            throw new \InvalidArgumentException('$notificationType must be either ' . implode(', ', $allowedNotificationType));
        }
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
    private function isValidAction(string $action)
    {
        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!in_array($action, $allowedSenderAction, true)) {
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
     * @param string $tag
     *
     * @throws \InvalidArgumentException
     */
    private function isValidTag(string $tag)
    {
        $allowedTag = $this->getAllowedTag();
        if (!in_array($tag, $allowedTag, true)) {
            throw new \InvalidArgumentException('$tag must be either ' . implode(', ', $allowedTag));
        }
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
