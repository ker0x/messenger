<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Request\BroadcastRequest;
use Kerox\Messenger\Response\BroadcastResponse;
use Kerox\Messenger\SendInterface;

class Broadcast extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param string|\Kerox\Messenger\Model\Message $message
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Response\BroadcastResponse
     */
    public function create($message): BroadcastResponse
    {
        $message = $this->isValidMessage($message);

        $request = new BroadcastRequest($this->pageToken, $message);
        $response = $this->client->post('me/message_creatives', $request->build());

        return new BroadcastResponse($response);
    }

    /**
     * @param string $messageCreativeId
     * @param array  $options
     *
     * @return \Kerox\Messenger\Response\BroadcastResponse
     */
    public function send(string $messageCreativeId, array $options = []): BroadcastResponse
    {
        $options = $this->isValidOptions($options);

        $request = new BroadcastRequest($this->pageToken, null, $messageCreativeId, $options);
        $response = $this->client->post('me/broadcast_messages', $request->build());

        return new BroadcastResponse($response);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function isValidOptions(array $options): array
    {
        $allowedOptionsKeys = $this->getAllowedOptionsKeys();
        foreach ($options as $key => $value) {
            if (!\in_array($key, $allowedOptionsKeys, true)) {
                throw new \InvalidArgumentException(sprintf(
                    'Only %s are allowed keys for options.',
                    implode(', ', $allowedOptionsKeys)
                ));
            }

            if ($key === self::OPTION_NOTIFICATION_TYPE) {
                $this->isValidNotificationType($value);
            } elseif ($key === self::OPTION_TAG) {
                $this->isValidTag($value);
            }
        }

        return $options;
    }

    /**
     * @return array
     */
    private function getAllowedOptionsKeys(): array
    {
        return [
            self::OPTION_NOTIFICATION_TYPE,
            self::OPTION_TAG,
        ];
    }
}
