<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Message;

class SendRequest extends AbstractRequest
{
    public const REQUEST_TYPE_MESSAGE = 'message';
    public const REQUEST_TYPE_ACTION = 'action';

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
     * @var string
     */
    protected $messagingType;

    /**
     * Request constructor.
     *
     * @param string                                $pageToken
     * @param string|\Kerox\Messenger\Model\Message $content
     * @param string|null                           $recipient
     * @param array                                 $options
     * @param string                                $requestType
     */
    public function __construct(
        string $pageToken,
        $content,
        ?string $recipient = null,
        array $options = [],
        string $requestType = self::REQUEST_TYPE_MESSAGE
    ) {
        parent::__construct($pageToken);

        if ($content instanceof Message || $requestType === self::REQUEST_TYPE_MESSAGE) {
            $this->message = $content;
        } else {
            $this->senderAction = $content;
        }

        $this->recipient = \is_string($recipient) ? ['id' => $recipient] : $recipient;
        $this->messagingType = $options['messaging_type'] ?? null;
        $this->notificationType = $options['notification_type'] ?? null;
        $this->tag = $options['tag'] ?? null;
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
            'messaging_type' => $this->messagingType,
            'recipient' => $this->recipient,
            'message' => $this->message,
            'sender_action' => $this->senderAction,
            'notification_type' => $this->notificationType,
            'tag' => $this->tag,
        ];

        return array_filter($body);
    }
}
