<?php

namespace Kerox\Messenger\Model\Callback;

class PolicyEnforcement
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @var null|string
     */
    protected $reason;

    /**
     * PolicyEnforcement constructor.
     *
     * @param string      $action
     * @param null|string $reason
     */
    public function __construct(string $action, $reason)
    {
        $this->action = $action;
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return null|string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param array $callbackData
     *
     * @return \Kerox\Messenger\Model\Callback\PolicyEnforcement
     */
    public static function create(array $callbackData): self
    {
        $reason = $callbackData['reason'] ?? null;

        return new static($callbackData['action'], $reason);
    }
}
