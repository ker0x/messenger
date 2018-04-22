<?php

declare(strict_types=1);

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\GamePlay;

class GamePlayEvent extends AbstractEvent
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
     *
     * @param string                                   $senderId
     * @param string                                   $recipientId
     * @param int                                      $timestamp
     * @param \Kerox\Messenger\Model\Callback\GamePlay $gamePlay
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, GamePlay $gamePlay)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->gamePlay = $gamePlay;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\GamePlay
     */
    public function getGamePlay(): GamePlay
    {
        return $this->gamePlay;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param array $payload
     *
     * @return mixed
     */
    public static function create(array $payload)
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $gamePlay = GamePlay::create($payload['game_play']);

        return new static($senderId, $recipientId, $timestamp, $gamePlay);
    }
}
