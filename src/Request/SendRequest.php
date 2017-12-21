<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Message;

class SendRequest extends AbstractRequest
{
    public const REQUEST_TYPE_MESSAGE = 'message';
    public const REQUEST_TYPE_ACTION = 'action';

    public const MESSAGING_TYPE_RESPONSE = 'RESPONSE';
    public const MESSAGING_TYPE_UPDATE = 'UPDATE';
    public const MESSAGING_TYPE_MESSAGE_TAG = 'MESSAGE_TAG';
    public const MESSAGING_TYPE_NON_PROMOTIONAL_SUBSCRIPTION = 'NON_PROMOTIONAL_SUBSCRIPTION';

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
     * @param string|null                           $notificationType
     * @param string|null                           $tag
     * @param string                                $requestType
     * @param string                                $messagingType
     */
    public function __construct(
        string $pageToken,
        $content,
        ?string $recipient = null,
        ?string $notificationType = null,
        ?string $tag = null,
        string $requestType = self::REQUEST_TYPE_MESSAGE,
        string $messagingType = self::MESSAGING_TYPE_RESPONSE
    ) {
        parent::__construct($pageToken);

        if ($content instanceof Message || $requestType === self::REQUEST_TYPE_MESSAGE) {
            $this->message = $content;
        } else {
            $this->senderAction = $content;
        }

        $this->recipient = \is_string($recipient) ? ['id' => $recipient] : $recipient;
        $this->notificationType = $notificationType;
        $this->messagingType = $messagingType;
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
            'messaging_type'    => $this->messagingType,
            'recipient'         => $this->recipient,
            'message'           => $this->message,
            'sender_action'     => $this->senderAction,
            'notification_type' => $this->notificationType,
            'tag'               => $this->tag,
        ];

        return array_filter($body);
    }
}
