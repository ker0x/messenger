<?php
namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;

class ThreadSettings implements \JsonSerializable
{

    use ValidatorTrait;

    const TYPE_GREETING = 'greeting';
    const TYPE_CALL_TO_ACTIONS = 'call_to_actions';
    const TYPE_DOMAIN_WHITELISTING = 'domain_whitelisting';
    const TYPE_ACCOUNT_LINKING = 'account_linking';
    const TYPE_PAYMENT = 'payment';

    const STATE_NEW_THREAD = 'new_thread';
    const STATE_EXISTING_THREAD = 'existing_thread';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var null|string
     */
    protected $state;

    /**
     * ThreadSettings constructor.
     *
     * @param string $type
     * @param string $state
     */
    public function __construct(string $type, string $state = null)
    {
        $this->type = $type;

        if ($state !== null && $type === self::TYPE_CALL_TO_ACTIONS) {
            $this->isValidState($state);
            $this->state = $state;
        }
    }

    /**
     * @param string $state
     * @throws \InvalidArgumentException
     */
    private function isValidState(string $state)
    {
        $allowedState = $this->getAllowedState();
        if (!in_array($state, $allowedState)) {
            throw new \InvalidArgumentException('$state must be either ' . implode(', ', $allowedState));
        }
    }

    /**
     * @return array
     */
    private function getAllowedState(): array
    {
        return [
            ThreadSettings::STATE_NEW_THREAD,
            ThreadSettings::STATE_EXISTING_THREAD,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'setting_type' => $this->type,
            'thread_state' => $this->state,
        ];

        return array_filter($json);
    }
}
