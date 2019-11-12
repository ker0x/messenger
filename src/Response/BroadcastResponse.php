<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class BroadcastResponse extends AbstractResponse
{
    private const MESSAGE_CREATIVE_ID = 'message_creative_id';
    private const BROADCAST_ID = 'broadcast_id';

    /**
     * @var string|null
     */
    protected $messageCreativeId;

    /**
     * @var string|null
     */
    protected $broadcastId;

    protected function parseResponse(array $response): void
    {
        $this->messageCreativeId = $response[self::MESSAGE_CREATIVE_ID] ?? null;
        $this->broadcastId = $response[self::BROADCAST_ID] ?? null;
    }

    public function getMessageCreativeId(): ?string
    {
        return $this->messageCreativeId;
    }

    public function getBroadcastId(): ?string
    {
        return $this->broadcastId;
    }
}
