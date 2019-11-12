<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class GamePlay
{
    /**
     * @var string
     */
    protected $gameId;

    /**
     * @var string
     */
    protected $playerId;

    /**
     * @var string
     */
    protected $contextType;

    /**
     * @var string
     */
    protected $contextId;

    /**
     * @var int
     */
    protected $score;

    /**
     * @var string
     */
    protected $payload;

    /**
     * GamePlay constructor.
     */
    public function __construct(
        string $gameId,
        string $playerId,
        string $contextType,
        string $contextId,
        int $score,
        string $payload
    ) {
        $this->gameId = $gameId;
        $this->playerId = $playerId;
        $this->contextType = $contextType;
        $this->contextId = $contextId;
        $this->score = $score;
        $this->payload = $payload;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function getPlayerId(): string
    {
        return $this->playerId;
    }

    public function getContextType(): string
    {
        return $this->contextType;
    }

    public function getContextId(): string
    {
        return $this->contextId;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\GamePlay
     */
    public static function create(array $callbackData): self
    {
        return new self(
            $callbackData['game_id'],
            $callbackData['player_id'],
            $callbackData['context_type'],
            $callbackData['context_id'],
            $callbackData['score'],
            $callbackData['payload']
        );
    }
}
