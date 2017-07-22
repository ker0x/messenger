<?php

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
     * @return void
     */
    public function setSubtitle(string $subtitle)
    {
        $this->isValidString($subtitle, 80);

        $this->subtitle = $subtitle;
    }

    /**
     * @param mixed $imageUrl
     * @return void
     */
    public function setImageUrl(string $imageUrl)
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
