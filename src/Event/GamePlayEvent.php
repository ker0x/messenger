<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\GamePlay;

final class GamePlayEvent extends AbstractEvent
{
    public const NAME = 'game_play';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\GamePlay
     */
    protected $gamePlay;

    /**
     * GamePlayEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, GamePlay $gamePlay)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->gamePlay = $gamePlay;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getGamePlay(): GamePlay
    {
        return $this->gamePlay;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Kerox\Messenger\Event\GamePlayEvent
     */
    public static function create(array $payload)
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $gamePlay = GamePlay::create($payload['game_play']);

        return new self($senderId, $recipientId, $timestamp, $gamePlay);
    }
}
