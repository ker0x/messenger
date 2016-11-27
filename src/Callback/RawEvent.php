<?php
namespace Kerox\Messenger\Callback;

class RawEvent extends AbstractCallbackEvent
{

    /**
     * @var array
     */
    protected $raw;

    /**
     * RawEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param array $raw
     */
    public function __construct(string $senderId, string $recipientId, array $raw)
    {
        parent::__construct($senderId, $recipientId);

        $this->raw = $raw;
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }
}
