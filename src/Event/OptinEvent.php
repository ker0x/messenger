<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Optin;

final class OptinEvent extends AbstractEvent
{
    public const NAME = 'optin';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Optin
     */
    protected $optin;

    /**
     * OptinEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Optin $optin)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->optin = $optin;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getOptin(): Optin
    {
        return $this->optin;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\OptinEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $optin = Optin::create($payload['optin']);

        return new self($senderId, $recipientId, $timestamp, $optin);
    }
}
