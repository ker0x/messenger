<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\ValidatorTrait;

abstract class AbstractElement implements \JsonSerializable, ElementInterface
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
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\AbstractElement
     */
    public function setSubtitle(string $subtitle): AbstractElement
    {
        $this->isValidString($subtitle, 80);
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * @param mixed $imageUrl
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\AbstractElement
     */
    public function setImageUrl(string $imageUrl): AbstractElement
    {
        $this->isValidUrl($imageUrl);
        $this->imageUrl = $imageUrl;

        return $this;
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
