<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Callback;

class PolicyEnforcement
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @var string|null
     */
    protected $reason;

    /**
     * PolicyEnforcement constructor.
     */
    public function __construct(string $action, ?string $reason = null)
    {
        $this->action = $action;
        $this->reason = $reason;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\PolicyEnforcement
     */
    public static function create(array $callbackData): self
    {
        $reason = $callbackData['reason'] ?? null;

        return new self($callbackData['action'], $reason);
    }
}
