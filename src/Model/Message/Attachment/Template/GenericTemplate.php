<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class GenericTemplate extends Template
{
    const IMAGE_RATIO_HORIZONTAL  = 'horizontal';
    const IMAGE_RATIO_SQUARE  = 'square';

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[]
     */
    protected $elements;

    /**
     * @var string
     */
    protected $imageRatio;

    /**
     * Generic constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[] $elements
     * @param  string $imageRatio
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(array $elements, $imageRatio = self::IMAGE_RATIO_HORIZONTAL)
    {
        parent::__construct();

        $this->isValidArray($elements, 10);

        $this->elements = $elements;
        $this->imageRatio = $imageRatio;
    }

    /**
     * @param array $elements
     * @param  string $imageRatio
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate
     */
    public static function create(array $elements, $imageRatio = self::IMAGE_RATIO_HORIZONTAL): self
    {
        return new self($elements, $imageRatio);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => Template::TYPE_GENERIC,
                'elements' => $this->elements,
                'image_aspect_ratio' => $this->imageRatio,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
