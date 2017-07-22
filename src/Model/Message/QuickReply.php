<?php

namespace Kerox\Messenger\Model\Message;

use Kerox\Messenger\Helper\ValidatorTrait;

class QuickReply implements \JsonSerializable
{

    use ValidatorTrait;

    const CONTENT_TYPE_TEXT = 'text';
    const CONTENT_TYPE_LOCATION = 'location';

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $payload;

    /**
     * @var null|string
     */
    protected $imageUrl;

    /**
     * QuickReply constructor.
     *
     * @param string $contentType
     * @throws \Exception
     */
    public function __construct(string $contentType)
    {
        $this->isValidContentType($contentType);

        $this->contentType = $contentType;
    }

    /**
     * @param string $title
     * @return \Kerox\Messenger\Model\Message\QuickReply
     */
    public function setTitle(string $title): QuickReply
    {
        $this->checkContentType();
        $this->isValidString($title, 20);

        $this->title = $title;

        return $this;
    }

    /**
     * @param mixed $payload
     * @return \Kerox\Messenger\Model\Message\QuickReply
     */
    public function setPayload(string $payload): QuickReply
    {
        $this->checkContentType();
        $this->isValidString($payload, 1000);

        $this->payload = $payload;

        return $this;
    }

    /**
     * @param mixed $imageUrl
     * @return \Kerox\Messenger\Model\Message\QuickReply
     */
    public function setImageUrl(string $imageUrl): QuickReply
    {
        $this->checkContentType();
        $this->isValidUrl($imageUrl);
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @param string $contentType
     * @throws \InvalidArgumentException
     */
    private function isValidContentType(string $contentType)
    {
        $allowedContentType = $this->getAllowedContentType();
        if (!in_array($contentType, $allowedContentType)) {
            throw new \InvalidArgumentException('Invalid content type');
        }
    }

    /**
     * @return array
     */
    private function getAllowedContentType(): array
    {
        return [
            self::CONTENT_TYPE_TEXT,
            self::CONTENT_TYPE_LOCATION,
        ];
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function checkContentType()
    {
        if ($this->contentType === self::CONTENT_TYPE_LOCATION) {
            throw new \Exception('Content type is set to location');
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $quickReply = [
            'content_type' => $this->contentType,
            'title' => $this->title,
            'payload' => $this->payload,
            'image_url' => $this->imageUrl,
        ];

        return array_filter($quickReply);
    }
}
