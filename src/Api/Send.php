<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Exception\InvalidOptionException;
use Kerox\Messenger\Exception\InvalidTypeException;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\SendInterface;

class Send extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param mixed $message
     *
     * @throws \Exception
     */
    public function message(string $recipient, $message, array $options = []): SendResponse
    {
        $this->isValidOptions($options, $message);
        $message = $this->isValidMessage($message);

        $request = new SendRequest($this->pageToken, $message, $recipient, $options);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function action(string $recipient, string $action, array $options = []): SendResponse
    {
        $this->isValidSenderAction($action);
        $this->isValidOptions($options);

        $request = new SendRequest($this->pageToken, $action, $recipient, $options, SendRequest::REQUEST_TYPE_ACTION);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @throws \Exception
     */
    public function attachment(Attachment $attachment): SendResponse
    {
        $message = $this->isValidMessage($attachment);

        $request = new SendRequest($this->pageToken, $message);
        $response = $this->client->post('me/message_attachments', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param mixed $message
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidOptions(array $options, $message = null): void
    {
        $allowedOptionsKeys = $this->getAllowedOptionsKeys();
        foreach ($options as $key => $value) {
            if (!\in_array($key, $allowedOptionsKeys, true)) {
                throw new InvalidOptionException(sprintf('Only "%s" are allowed keys for options.', implode(', ', $allowedOptionsKeys)));
            }

            if ($key === self::OPTION_MESSAGING_TYPE) {
                $this->isValidMessagingType($value);
            } elseif ($key === self::OPTION_NOTIFICATION_TYPE) {
                $this->isValidNotificationType($value);
            } elseif ($key === self::OPTION_TAG) {
                $this->isValidTag($value, $message);
            }
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    protected function isValidMessagingType(string $messagingType): void
    {
        $allowedMessagingType = $this->getAllowedMessagingType();
        if (!\in_array($messagingType, $allowedMessagingType, true)) {
            throw new InvalidTypeException(sprintf('messagingType must be either "%s".', implode(', ', $allowedMessagingType)));
        }
    }

    private function getAllowedOptionsKeys(): array
    {
        return [
            self::OPTION_MESSAGING_TYPE,
            self::OPTION_NOTIFICATION_TYPE,
            self::OPTION_TAG,
            self::OPTION_PERSONA_ID,
        ];
    }

    public function getAllowedMessagingType(): array
    {
        return [
            self::MESSAGING_TYPE_RESPONSE,
            self::MESSAGING_TYPE_MESSAGE_TAG,
            self::MESSAGING_TYPE_NON_PROMOTIONAL_SUBSCRIPTION,
            self::MESSAGING_TYPE_UPDATE,
        ];
    }
}
