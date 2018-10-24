<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\SendInterface;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class BroadcastRequest extends AbstractRequest implements BodyRequestInterface
{
    use UtilityTrait;

    public const REQUEST_TYPE_MESSAGE = 'message';
    public const REQUEST_TYPE_ACTION = 'action';

    /**
     * @var null|Message
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
     * @var string|null
     */
    protected $messagingType;

    /**
     * Request constructor.
     *
     * @param string       $path
     * @param Message|null $message
     * @param string|null  $messageCreativeId
     * @param array        $options
     */
    public function __construct(
        string $path,
        ?Message $message = null,
        ?string $messageCreativeId = null,
        array $options = []
    ) {
        parent::__construct($path);

        $this->message = $message;
        $this->messageCreativeId = $messageCreativeId;
        $this->messagingType = $options[SendInterface::OPTION_MESSAGING_TYPE] ?? null;
        $this->notificationType = $options[SendInterface::OPTION_NOTIFICATION_TYPE] ?? null;
        $this->tag = $options[SendInterface::OPTION_TAG] ?? null;
    }

    /**
     * @param string $method
     *
     * @return RequestInterface
     */
    public function build(string $method = 'post'): RequestInterface
    {
        return $this->origin
            ->withMethod($method)
            ->withBody(stream_for($this->buildBody()));
    }

    /**
     * @return string
     */
    public function buildBody(): string
    {
        $body = [
            'messages' => [
                $this->message,
            ],
            'message_creative_id' => $this->messageCreativeId,
            'messaging_type' => $this->messagingType,
            'notification_type' => $this->notificationType,
            'tag' => $this->tag,
        ];

        return \json_encode($this->arrayFilter($body));
    }
}
