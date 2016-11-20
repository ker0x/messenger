<?php
namespace Kerox\Messenger\Message;

use Kerox\Messenger\ValidatorTrait;

class Message implements \JsonSerializable
{

    use ValidatorTrait;

    const TYPE_TEXT = 'text';
    const TYPE_ATTACHMENT = 'attachment';

    /**
     * @var string
     */
    protected $type = self::TYPE_TEXT;

    /**
     * @var \Kerox\Messenger\Message\Attachment|string
     */
    protected $message;

    /**
     * @var array
     */
    protected $quickReplies = [];

    /**
     * @var string
     */
    protected $metadata;

    /**
     * Message constructor.
     *
     * @param \Kerox\Messenger\Message\Attachment|string $message
     */
    public function __construct($message)
    {
        if (is_string($message)) {
            $this->isValidString($message, 320);
        } elseif ($message instanceof Attachment) {
            $this->type = self::TYPE_ATTACHMENT;
        }

        $this->message = $message;
    }

    /**
     * @param mixed $quickReplies
     * @return Message
     * @throws \Exception
     */
    public function setQuickReplies(array $quickReplies): Message
    {
        $this->isValidArray($quickReplies, 10);
        $this->quickReplies = $quickReplies;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Message\QuickReply $quickReply
     * @return \Kerox\Messenger\Message\Message
     */
    public function addQuickReply(QuickReply $quickReply): Message
    {
        $this->quickReplies[] = $quickReply;

        return $this;
    }

    /**
     * @param mixed $metadata
     * @return Message
     */
    public function setMetadata(string $metadata): Message
    {
        $this->isValidString($metadata, 1000);
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $message = [
            $this->type => $this->message,
            'quick_replies' => $this->quickReplies,
            'metadata' => $this->metadata,
        ];

        return array_filter($message);
    }
}