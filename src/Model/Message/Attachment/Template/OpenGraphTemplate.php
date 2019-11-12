<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class OpenGraphTemplate extends Template
{
    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement[]
     */
    protected $elements = [];

    /**
     * OpenGraph constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement[] $elements
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 1);

        $this->elements = $elements;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\OpenGraphTemplate
     */
    public static function create(array $elements): self
    {
        return new self($elements);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => Template::TYPE_OPEN_GRAPH,
                'elements' => $this->elements,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
