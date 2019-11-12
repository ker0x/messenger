<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class Reaction
{
    public const REACTION_SMILE = 'smile';
    public const REACTION_ANGRY = 'angry';
    public const REACTION_SAD = 'sad';
    public const REACTION_WOW = 'wow';
    public const REACTION_LOVE = 'love';
    public const REACTION_LIKE = 'like';
    public const REACTION_DISLIKE = 'dislike';
    public const REACTION_OTHER = 'other';

    public const ACTION_REACT = 'react';
    public const ACTION_UNREACT = 'unreact';

    protected $reaction;
    protected $emoji;
    protected $action;
    protected $mid;

    /**
     * Reaction constructor.
     */
    public function __construct(string $reaction, string $emoji, string $action, string $mid)
    {
        $this->reaction = $reaction;
        $this->emoji = $emoji;
        $this->action = $action;
        $this->mid = $mid;
    }

    public function getReaction(): string
    {
        return $this->reaction;
    }

    public function getEmoji(): string
    {
        return $this->emoji;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getMid(): string
    {
        return $this->mid;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Reaction
     */
    public static function create(array $callbackData): self
    {
        return new self(
            $callbackData['reaction'],
            $callbackData['emoji'],
            $callbackData['action'],
            $callbackData['mid']
        );
    }
}
