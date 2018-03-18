<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Request\BroadcastRequest;
use Kerox\Messenger\Response\BroadcastResponse;

class Broadcast extends AbstractApi
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
        string $notificationType = Send::NOTIFICATION_TYPE_REGULAR,
        ?string $tag = null
    ): BroadcastResponse {
        $this->isValidNotificationType($notificationType, $this->getAllowedNotificationType());

        if ($tag !== null) {
            $this->isValidTag($tag, $this->getAllowedTag());
        }

        $request = new BroadcastRequest($this->pageToken, null, $messageCreativeId, $notificationType, $tag);
        $response = $this->client->post('me/broadcast_messages', $request->build());

        return new BroadcastResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedNotificationType(): array
    {
        return [
            Send::NOTIFICATION_TYPE_REGULAR,
            Send::NOTIFICATION_TYPE_SILENT_PUSH,
            Send::NOTIFICATION_TYPE_NO_PUSH,
        ];
    }

    /**
     * @return array
     */
    private function getAllowedTag(): array
    {
        return [
            Send::TAG_ISSUE_RESOLUTION,
            Send::TAG_RESERVATION_UPDATE,
            Send::TAG_SHIPPING_UPDATE,
            Send::TAG_APPOINTMENT_UPDATE,
            Send::TAG_GAME_EVENT,
            Send::TAG_TRANSPORTATION_UPDATE,
            Send::TAG_FEATURE_FUNCTIONALITY_UPDATE,
            Send::TAG_TICKET_UPDATE,
            Send::TAG_ACCOUNT_UPDATE,
            Send::TAG_PAYMENT_UPDATE,
            Send::TAG_PERSONAL_FINANCE_UPDATE,
        ];
    }
}
