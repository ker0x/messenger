<?php

namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\PolicyEnforcement;

class PolicyEnforcementEvent extends AbstractEvent
{
    public const NAME = 'policy_enforcement';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\PolicyEnforcement
     */
    protected $policyEnforcement;

    /**
     * ReadEvent constructor.
     *
     * @param string                                            $senderId
     * @param string                                            $recipientId
     * @param int                                               $timestamp
     * @param \Kerox\Messenger\Model\Callback\PolicyEnforcement $policyEnforcement
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, PolicyEnforcement $policyEnforcement)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->policyEnforcement = $policyEnforcement;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\PolicyEnforcement
     */
    public function getPolicyEnforcement(): PolicyEnforcement
    {
        return $this->policyEnforcement;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param $payload
     *
     * @return \Kerox\Messenger\Event\PolicyEnforcementEvent
     */
    public static function create(array $payload): self
    {
        $senderId = isset($payload['sender']) ? $payload['sender']['id'] : '';
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $policyEnforcement = PolicyEnforcement::create($payload['policy-enforcement']);

        return new static($senderId, $recipientId, $timestamp, $policyEnforcement);
    }
}
