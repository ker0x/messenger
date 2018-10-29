<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\SendInterface;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\stream_for;

class SendRequest extends AbstractRequest implements BodyRequestInterface
{
    use UtilityTrait;

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
     * @var null|string
     */
    protected $personaId;

    /**
     * @var string
     */
    protected $messagingType;

    /**
     * Request constructor.
     *
     * @param string                                $path
     * @param string|\Kerox\Messenger\Model\Message $content
     * @param string|null                           $recipient
     * @param array                                 $options
     * @param string                                $requestType
     */
    public function __construct(
        string $path,
        $content,
        ?string $recipient = null,
        array $options = [],
        string $requestType = self::REQUEST_TYPE_MESSAGE
    ) {
        parent::__construct($path);

        if ($content instanceof Message || $requestType === self::REQUEST_TYPE_MESSAGE) {
            $this->message = $content;
        } else {
            $this->senderAction = $content;
        }

        $this->recipient = \is_string($recipient) ? ['id' => $recipient] : $recipient;
        $this->messagingType = $options[SendInterface::OPTION_MESSAGING_TYPE] ?? null;
        $this->notificationType = $options[SendInterface::OPTION_NOTIFICATION_TYPE] ?? null;
        $this->tag = $options[SendInterface::OPTION_TAG] ?? null;
        $this->personaId = $options[SendInterface::OPTION_PERSONA_ID] ?? null;
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
            'messaging_type' => $this->messagingType,
            'recipient' => $this->recipient,
            'message' => $this->message,
            'sender_action' => $this->senderAction,
            'notification_type' => $this->notificationType,
            'tag' => $this->tag,
            'persona_id' => $this->personaId,
        ];

        return json_encode($this->arrayFilter($body));
    }
}
