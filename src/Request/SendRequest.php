<?php
namespace Kerox\Messenger\Request;

class SendRequest extends AbstractRequest
{

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var null|string|\Kerox\Messenger\Model\Message
     */
    protected $message;

    /**
     * @var null|string
     */
    protected $senderAction;

    /**
     * @var null|string
     */
    protected $notificationType;

    /**
     * Request constructor.
     *
     * @param string $pageToken
     * @param string $recipient
     * @param $message
     * @param $senderAction
     * @param $notificationType
     */
    public function __construct(string $pageToken, string $recipient, $message, $senderAction, $notificationType)
    {
        parent::__construct($pageToken);

        $this->recipient = $recipient;
        $this->message = $message;
        $this->senderAction = $senderAction;
        $this->notificationType = $notificationType;
    }

    /**
     * @return array
     */
    protected function buildHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return array
     */
    protected function buildBody(): array
    {
        $body = [
            'recipient' => [
                'id' => $this->recipient,
            ],
            'message' => $this->message,
            'sender_action' => $this->senderAction,
            'notification_type' => $this->notificationType,
        ];

        return array_filter($body);
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        parent::buildQuery();
    }
}
