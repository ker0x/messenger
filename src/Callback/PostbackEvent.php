<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\Postback;

class PostbackEvent extends AbstractCallbackEvent
{

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
        parent::__construct($senderId, $recipientId, $timestamp);

        $this->postback = $postback;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Postback
     */
    public function getPostback(): Postback
    {
        return $this->postback;
    }
}