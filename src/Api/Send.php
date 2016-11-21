<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Model\Message\Message;
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

    /**
     * Send constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(string $pageToken, Client $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @param string $recipient
     * @param $message
     * @param string $notificationType
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function message(string $recipient, $message, string $notificationType = self::NOTIFICATION_TYPE_REGULAR): SendResponse
    {
        $message = $this->isValidMessage($message);
        $this->isValidNotificationType($notificationType);

        $request = new SendRequest($this->pageToken, $recipient, $message, null, $notificationType);
        $response = $this->client->post('/me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param string $recipient
     * @param string $action
     * @param string $notificationType
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(string $recipient, string $action, string $notificationType = self::NOTIFICATION_TYPE_REGULAR): SendResponse
    {
        $this->isValidAction($action);
        $this->isValidNotificationType($notificationType);

        $request = new SendRequest($this->pageToken, $recipient, null, $action, $notificationType);
        $response = $this->client->post('/me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param $message
     * @return Message
     * @throws \InvalidArgumentException
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
     */
    private function isValidNotificationType(string $notificationType)
    {
        $allowedNotificationType = $this->getAllowedNotificationType();
        if (!in_array($notificationType, $allowedNotificationType)) {
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
            self::NOTIFICATION_TYPE_NO_PUSH,
            self::NOTIFICATION_TYPE_SILENT_PUSH,
        ];
    }

    /**
     * @param string $action
     */
    private function isValidAction(string $action)
    {
        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!in_array($action, $allowedSenderAction)) {
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
}
