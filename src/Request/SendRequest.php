<?php

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Message;

class SendRequest extends AbstractRequest
{
    const TYPE_MESSAGE = 'message';
    const TYPE_ACTION = 'action';

    /**
     * @var null|array
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
     * @var null|string
     */
    protected $tag;

    /**
     * Request constructor.
     *
     * @param string                                $pageToken
     * @param string|\Kerox\Messenger\Model\Message $content
     * @param string|null                           $recipient
     * @param string|null                           $notificationType
     * @param string|null                           $tag
     * @param string                                $requestType
     */
    public function __construct(
        string $pageToken,
        $content,
        ?string $recipient = null,
        ?string $notificationType = null,
        ?string $tag = null,
        string $requestType = self::TYPE_MESSAGE
    ) {
        parent::__construct($pageToken);

        if ($content instanceof Message || $requestType === self::TYPE_MESSAGE) {
            $this->message = $content;
        } else {
            $this->senderAction = $content;
        }

        $this->recipient = (is_string($recipient)) ? ['id' => $recipient] : $recipient;
        $this->notificationType = $notificationType;
        $this->tag = $tag;
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
            'recipient'         => $this->recipient,
            'message'           => $this->message,
            'sender_action'     => $this->senderAction,
            'notification_type' => $this->notificationType,
            'tag'               => $this->tag,
        ];

        return array_filter($body);
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
