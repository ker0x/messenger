<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings;

class StartButton extends ThreadSettings
{

    /**
     * @var string
     */
    protected $payload;

    /**
     * StartButton constructor.
     *
     * @param string $payload
     */
    public function __construct(string $payload)
    {
        parent::__construct(ThreadSettings::TYPE_CALL_TO_ACTIONS, ThreadSettings::STATE_NEW_THREAD);

        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'call_to_actions' => [
                [
                    'payload' => $this->payload,
                ],
            ],
        ];

        return $json;
    }
}
