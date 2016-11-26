<?php
namespace Kerox\Messenger\Callback;

use Kerox\Messenger\Model\Callback\Optin;

class OptinEvent extends AbstractCallbackEvent
{

    /**
     * @var \Kerox\Messenger\Model\Callback\Optin
     */
    protected $optin;

    /**
     * OptinEvent constructor.
     *
     * @param string $senderId
     * @param string $recipientId
     * @param int $timestamp
     * @param \Kerox\Messenger\Model\Callback\Optin $optin
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Optin $optin)
    {
        parent::__construct($senderId, $recipientId, $timestamp);

        $this->optin = $optin;
    }

    /**
     * @return \Kerox\Messenger\Model\Callback\Optin
     */
    public function getOptin(): Optin
    {
        return $this->optin;
    }
}
