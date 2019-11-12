<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

class RawEvent extends AbstractEvent
{
    public const NAME = 'raw';

    /**
     * @var array
     */
    protected $raw;

    /**
     * RawEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, array $raw)
    {
        parent::__construct($senderId, $recipientId);

        $this->raw = $raw;
    }

    public function getRaw(): array
    {
        return $this->raw;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\RawEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        unset($payload['sender'], $payload['recipient']);

        return new static($senderId, $recipientId, $payload);
    }
}
