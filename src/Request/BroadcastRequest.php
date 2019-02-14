<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\Message;
use Kerox\Messenger\SendInterface;

class BroadcastRequest extends AbstractRequest
{
    public const REQUEST_TYPE_MESSAGE = 'message';
    public const REQUEST_TYPE_ACTION = 'action';

    /**
     * @var string|\Kerox\Messenger\Model\Message|null
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $messageCreativeId;

    /**
     * @var string|null
     */
    protected $notificationType;

    /**
     * @var string|null
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
     * @param array                               $options
     */
    public function __construct(
        string $pageToken,
        ?Message $message = null,
        ?string $messageCreativeId = null,
        array $options = []
    ) {
        parent::__construct($pageToken);

        $this->message = $message;
        $this->messageCreativeId = $messageCreativeId;
        $this->notificationType = $options[SendInterface::OPTION_NOTIFICATION_TYPE] ?? null;
        $this->tag = $options[SendInterface::OPTION_TAG] ?? null;
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
            'messages' => [
                $this->message,
            ],
            'message_creative_id' => $this->messageCreativeId,
            'notification_type' => $this->notificationType,
            'tag' => $this->tag,
        ];

        return array_filter($body);
    }
}
