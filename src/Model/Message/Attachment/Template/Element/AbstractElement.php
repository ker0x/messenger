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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $title)
    {
        $this->isValidString($title, 80);

        $this->title = $title;
    }

    /**
     * @param mixed $subtitle
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function setSubtitle(string $subtitle)
    {
        $this->isValidString($subtitle, 80);

        $this->subtitle = $subtitle;
    }

    /**
     * @param mixed $imageUrl
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function setImageUrl(string $imageUrl)
    {
        $this->isValidUrl($imageUrl);

        $this->imageUrl = $imageUrl;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'title' => $this->title,
        ];

        return $array;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
