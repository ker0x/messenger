<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Helper\ValidatorTrait;

abstract class AbstractElement implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $subtitle;

    /**
     * @var null|string
     */
    protected $imageUrl;

    /**
     * AbstractElement constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->isValidString($title, 80);

        $this->title = $title;
    }

    /**
     * @param mixed $subtitle
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->isValidString($subtitle, 80);

        $this->subtitle = $subtitle;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->isValidUrl($imageUrl);

        $this->imageUrl = $imageUrl;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'title' => $this->title,
        ];

        return $json;
    }
}
