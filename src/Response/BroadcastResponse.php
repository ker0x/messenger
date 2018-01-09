<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class BroadcastResponse extends AbstractResponse
{
    private const MESSAGE_CREATIVE_ID = 'message_creative_id';
    private const BROADCAST_ID = 'broadcast_id';

    /**
     * @var null|string
     */
    protected $messageCreativeId;

    /**
     * @var null|string
     */
    protected $broadcastId;

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        $this->messageCreativeId = $response[self::MESSAGE_CREATIVE_ID] ?? null;
        $this->broadcastId = $response[self::BROADCAST_ID] ?? null;
    }

    /**
     * @return null|string
     */
    public function getMessageCreativeId(): ?string
    {
        return $this->messageCreativeId;
    }

    /**
     * @return null|string
     */
    public function getBroadcastId(): ?string
    {
        return $this->broadcastId;
    }
}
