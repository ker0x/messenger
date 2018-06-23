<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class GenericTemplate extends Template
{
    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[]
     */
    protected $elements;

    /**
     * Generic constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[] $elements
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 10);

        $this->elements = $elements;
    }

    /**
     * @param array $elements
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate
     */
    public static function create(array $elements): self
    {
        return new self($elements);
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
            ],
        ];

        return $this->arrayFilter($array);
    }
}
