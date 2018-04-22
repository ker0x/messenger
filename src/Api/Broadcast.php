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
     * @param string      $messageCreativeId
     * @param string      $notificationType
     * @param string|null $tag
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\BroadcastResponse
     */
    public function send(
        string $messageCreativeId,
        string $notificationType = self::NOTIFICATION_TYPE_REGULAR,
        ?string $tag = null
    ): BroadcastResponse {
        $this->isValidNotificationType($notificationType);

        if ($tag !== null) {
            $this->isValidTag($tag);
        }

        $request = new BroadcastRequest($this->pageToken, null, $messageCreativeId, $notificationType, $tag);
        $response = $this->client->post('me/broadcast_messages', $request->build());

        return new BroadcastResponse($response);
    }
}
