<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Message;

class BroadcastRequest extends AbstractRequest
{
    public const REQUEST_TYPE_MESSAGE = 'message';
    public const REQUEST_TYPE_ACTION = 'action';

    public const MESSAGING_TYPE_RESPONSE = 'RESPONSE';
    public const MESSAGING_TYPE_UPDATE = 'UPDATE';
    public const MESSAGING_TYPE_MESSAGE_TAG = 'MESSAGE_TAG';
    public const MESSAGING_TYPE_NON_PROMOTIONAL_SUBSCRIPTION = 'NON_PROMOTIONAL_SUBSCRIPTION';

    /**
     * @var null|string|\Kerox\Messenger\Model\Message
     */
    protected $message;

    /**
     * @var null|string
     */
    protected $messageCreativeId;

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
     * @param string                              $pageToken
     * @param \Kerox\Messenger\Model\Message|null $message
     * @param string|null                         $messageCreativeId
     * @param string|null                         $notificationType
     * @param string|null                         $tag
     */
    public function __construct(
        string $pageToken,
        ?Message $message = null,
        ?string $messageCreativeId = null,
        ?string $notificationType = null,
        ?string $tag = null
    ) {
        parent::__construct($pageToken);

        $this->message = $message;
        $this->messageCreativeId = $messageCreativeId;
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
            'messages'            => [
                $this->message,
            ],
            'message_creative_id' => $this->messageCreativeId,
            'notification_type'   => $this->notificationType,
            'tag'                 => $this->tag,
        ];

        return array_filter($body);
    }
}
