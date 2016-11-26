<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\Read;

class ReadEvent extends AbstractCallbackEvent
{

    /**
     * @var \Kerox\Messenger\Model\Callback\Read
     */
    protected $read;

    /**
     * ReadEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Read $read
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Read $read)
    {
        parent::__construct($senderId, $recipientId, $timestamp);

        $this->read = $read;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Read
     */
    public function getRead(): Read
    {
        return $this->read;
    }
}
