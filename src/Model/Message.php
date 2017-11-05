<?php

namespace Kerox\Messenger\Model;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Model\Message\QuickReply;

class Message implements \JsonSerializable
{
    use ValidatorTrait;

    private const TYPE_TEXT = 'text';
    private const TYPE_ATTACHMENT = 'attachment';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment|string
     */
    protected $message;

    /**
     * @var \Kerox\Messenger\Model\Message\QuickReply[]
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
     * @param \Kerox\Messenger\Model\Message\QuickReply[] $quickReplies
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Model\Message
     */
    public function setQuickReplies(array $quickReplies): self
    {
        $this->isValidQuickReplies($quickReplies);

        $this->quickReplies = $quickReplies;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Message\QuickReply $quickReply
     *
     * @return \Kerox\Messenger\Model\Message
     */
    public function addQuickReply(QuickReply $quickReply): self
    {
        $this->quickReplies[] = $quickReply;

        return $this;
    }

    /**
     * @param mixed $metadata
     *
     * @return Message
     */
    public function setMetadata(string $metadata): self
    {
        $this->isValidString($metadata, 1000);

        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param array $quickReplies
     *
     * @throws \InvalidArgumentException
     */
    private function isValidQuickReplies(array $quickReplies): void
    {
        $this->isValidArray($quickReplies, 11, 1);
        foreach ($quickReplies as $quickReply) {
            if (!$quickReply instanceof QuickReply) {
                throw new \InvalidArgumentException('Array can only contain instance of QuickReply.');
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            $this->type     => $this->message,
            'quick_replies' => $this->quickReplies,
            'metadata'      => $this->metadata,
        ];

        return array_filter($json);
    }
}
