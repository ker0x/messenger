<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\SendInterface;

class Send extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Send
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        return new self($pageToken, $client);
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
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(
        string $recipient,
        string $action,
        string $notificationType = self::NOTIFICATION_TYPE_REGULAR
    ): SendResponse {
        $this->isValidSenderAction($action);
        $this->isValidNotificationType($notificationType);

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
}
