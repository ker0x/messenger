<?php
namespace Kerox\Messenger\Event;

use Kerox\Messenger\Model\Callback\Postback;

class PostbackEvent extends AbstractEvent
{

    const NAME = 'postback';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Kerox\Messenger\Model\Callback\Postback
     */
    protected $postback;

    /**
     * PostbackEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Postback $postback
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Postback $postback)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->postback = $postback;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Postback
     */
    public function getPostback(): Postback
    {
        return $this->postback;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
