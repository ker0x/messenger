<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\SendInterface;
use Psr\Log\InvalidArgumentException;

class Send extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param string                                $recipient
     * @param string|\Kerox\Messenger\Model\Message $message
     * @param array                                 $options
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function message(string $recipient, $message, array $options = []): SendResponse
    {
        $message = $this->isValidMessage($message);
        $options = $this->isValidOptions($options, $message);

        $request = new SendRequest($this->pageToken, $message, $recipient, $options);
        $response = $this->client->post('me/messages', $request->build());

        return new SendResponse($response);
    }

    /**
     * @param string $recipient
     * @param string $action
     * @param array  $options
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(string $recipient, string $action, array $options = []): SendResponse
    {
        $this->isValidSenderAction($action);
        $options = $this->isValidOptions($options, $action);

        $request = new SendRequest($this->pageToken, $action, $recipient, $options, SendRequest::REQUEST_TYPE_ACTION);
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
     * @param array $options
     * @param       $message
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    private function isValidOptions(array $options, $message): array
    {
        $allowedOptionsKeys = $this->getAllowedOptionsKeys();
        array_map(function ($key) use ($allowedOptionsKeys): void {
            if (!\in_array($key, $allowedOptionsKeys, true)) {
                throw new InvalidArgumentException(sprintf(
                    'Only "%s" are allowed keys for options.',
                    implode(', ', $allowedOptionsKeys)
                ));
            }
        }, array_keys($options));

        if (isset($options['messaging_type'])) {
            $this->isValidMessagingType($options['messaging_type']);
        }

        if (isset($options['notification_type'])) {
            $this->isValidNotificationType($options['notification_type']);
        }

        if (isset($options['tag'])) {
            $this->isValidTag($options['tag'], $message);
        }

        return $options;
    }

    /**
     * @return array
     */
    private function getAllowedOptionsKeys(): array
    {
        return [
            'messaging_type',
            'notification_type',
            'tag',
        ];
    }
}
