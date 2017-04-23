<?php

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Model\Message\QuickReply;
use Kerox\Messenger\Helper\ValidatorTrait;

class Message implements \JsonSerializable
{

    use ValidatorTrait;

    const TYPE_TEXT = 'text';
    const TYPE_ATTACHMENT = 'attachment';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment|string
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
     * @param \Kerox\Messenger\Model\Message\Attachment|string $message
     */
    public function __construct($message)
    {
        if (is_string($message)) {
            $this->isValidString($message, 640);
            $this->type = self::TYPE_TEXT;
        } elseif ($message instanceof Attachment) {
            $this->type = self::TYPE_ATTACHMENT;
        } else {
            throw new \InvalidArgumentException('$message must be a string or an instance of Attachment.');
        }

        $this->message = $message;
    }

    /**
     * @param mixed $quickReplies
     * @return \Kerox\Messenger\Model\Message
     * @throws \Exception
     */
    public function setQuickReplies(array $quickReplies): Message
    {
        $this->isValidArray($quickReplies, 11);
        $this->quickReplies = $quickReplies;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Message\QuickReply $quickReply
     * @return \Kerox\Messenger\Model\Message
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
        $json = [
            $this->type => $this->message,
            'quick_replies' => $this->quickReplies,
            'metadata' => $this->metadata,
        ];

        return array_filter($json);
    }
}
