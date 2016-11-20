<?php
namespace Kerox\Messenger;

use GuzzleHttp\Client;
use Kerox\Messenger\Message\Attachment;
use Kerox\Messenger\Message\Message;
use Kerox\Messenger\Request\MessageRequest;
use Kerox\Messenger\Request\UserProfileRequest;
use Kerox\Messenger\Response\MessageResponse;
use Kerox\Messenger\Response\UserProfileResponse;

class Messenger implements UserProfileInterface
{

    const API_URL = 'https://graph.facebook.com/';
    const API_VERSION = 'v2.6';

    const SENDER_ACTION_TYPING_ON = 'typing_on';
    const SENDER_ACTION_TYPING_OFF = 'typing_off';
    const SENDER_ACTION_MARK_SEEN = 'mark_seen';

    const NOTIFICATION_TYPE_REGULAR = 'REGULAR';
    const NOTIFICATION_TYPE_SILENT_PUSH = 'SILENT_PUSH';
    const NOTIFICATION_TYPE_NO_PUSH = 'NO_PUSH';

    /**
     * var string
     */
    protected $pageToken;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $senderAction;

    /**
     * @var string
     */
    protected $notificationType = self::NOTIFICATION_TYPE_REGULAR;

    /**
     * Messenger constructor.
     *
     * @param string $pageToken
     */
    public function __construct(string $pageToken)
    {
        $this->pageToken = $pageToken;
        $this->client = new Client([
            'base_uri' => self::API_URL . self::API_VERSION,
        ]);
    }

    /**
     * @param mixed $message
     * @return Messenger
     * @throws \Exception
     */
    public function setMessage($message): Messenger
    {
        if ($this->senderAction !== null) {
            throw new \Exception('sender_action is already defined');
        }
        $this->message = $this->isValidMessage($message);

        return $this;
    }

    /**
     * @param mixed $senderAction
     * @return Messenger
     * @throws \Exception
     */
    public function setSenderAction(string $senderAction): Messenger
    {
        if ($this->message !== null) {
            throw new \Exception('message is already defined');
        }

        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!in_array($senderAction, $allowedSenderAction)) {
            throw new \InvalidArgumentException('$senderAction must be either ' . implode(',', $allowedSenderAction));
        }
        $this->senderAction = $senderAction;

        return $this;
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
     * @param mixed $notificationType
     * @return Messenger
     */
    public function setNotificationType(string $notificationType): Messenger
    {
        $allowedNotificationType = $this->getAllowedNotificationType();
        if (!in_array($notificationType, $allowedNotificationType)) {
            throw new \InvalidArgumentException("\$notificationType must be either " . implode(',', $allowedNotificationType));
        }
        $this->notificationType = $notificationType;

        return $this;
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
     * @param $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    private function isValidMessage($message)
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
     * @param string $recipient
     * @return \Kerox\Messenger\Response\MessageResponse
     * @throws \Exception
     */
    public function sendTo(string $recipient): MessageResponse
    {
        if ($this->message === null && $this->senderAction === null) {
            throw new \Exception('message or sender_action must be defined');
        }

        $request = new MessageRequest($this->pageToken, $recipient, $this->message, $this->senderAction, $this->notificationType);
        $response = $this->client->post('/me/messages', $request->build());

        return new MessageResponse($response);
    }

    /**
     * @param string $userId
     * @param array|null $userProfileFields
     * @return \Kerox\Messenger\Response\UserProfileResponse
     */
    public function getUserProfile(string $userId, array $userProfileFields = null): UserProfileResponse
    {
        $allowedUserProfileFields = $this->getAllowedUserProfileFields();
        if ($userProfileFields !== null ) {
            foreach ($userProfileFields as $userProfileField) {
                if (!in_array($userProfileField, $allowedUserProfileFields)) {
                    throw new \InvalidArgumentException($userProfileField . ' is not a valid value. $userProfileFields must only contain ' . implode(',', $allowedUserProfileFields));
                }
            }
        } else {
            $userProfileFields = $allowedUserProfileFields;
        }

        $request = new UserProfileRequest($this->pageToken, $userProfileFields);
        $response = $this->client->get(sprintf('/%s', $userId), $request->build());

        return new UserProfileResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedUserProfileFields(): array
    {
        return [
            UserProfileInterface::FIRST_NAME,
            UserProfileInterface::LAST_NAME,
            UserProfileInterface::PROFILE_PIC,
            UserProfileInterface::LOCALE,
            UserProfileInterface::TIMEZONE,
            UserProfileInterface::GENDER,
            UserProfileInterface::IS_PAYMENT_ENABLED,
        ];
    }
}