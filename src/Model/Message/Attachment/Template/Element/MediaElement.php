<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Exception\InvalidTypeException;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Button\AbstractButton;

class MediaElement implements \JsonSerializable
{
    use ValidatorTrait;

    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';

    /**
     * @var string
     */
    protected $mediaType;

    /**
     * @var string|null
     */
    protected $attachmentId;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]|null
     */
    protected $buttons;

    /**
     * MediaElement constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, string $mediaType = self::TYPE_IMAGE)
    {
        if ($this->isAttachmentId($url)) {
            $this->attachmentId = $url;
        } else {
            $this->isValidUrl($url);
            $this->url = $url;
        }

        $this->isValidMediaType($mediaType);
        $this->mediaType = $mediaType;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\MediaElement
     */
    public static function create(string $url, string $mediaType = self::TYPE_IMAGE): self
    {
        return new self($url, $mediaType);
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\MediaElement
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 1);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->buttons = $buttons;

        return $this;
    }

    protected function getAllowedButtonsType(): array
    {
        return [
            AbstractButton::TYPE_WEB_URL,
        ];
    }

    private function isAttachmentId(string $value): bool
    {
        return (bool) preg_match('/^[\d]+$/', $value);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    private function isValidMediaType(string $mediaType): void
    {
        $allowedMediaType = $this->getAllowedMediaType();
        if (!\in_array($mediaType, $allowedMediaType, true)) {
            throw new InvalidTypeException(sprintf('mediaType must be either "%s".', implode(', ', $allowedMediaType)));
        }
    }

    protected function getAllowedMediaType(): array
    {
        return [
            self::TYPE_IMAGE,
            self::TYPE_VIDEO,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'media_type' => $this->mediaType,
            'attachment_id' => $this->attachmentId,
            'url' => $this->url,
            'buttons' => $this->buttons,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
