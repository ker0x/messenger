<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class OpenGraph extends Template
{
    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement[]
     */
    protected $elements = [];

    /**
     * OpenGraph constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement[] $elements
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 1);

        $this->elements = $elements;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type' => Template::TYPE_OPEN_GRAPH,
                'elements'      => $this->elements,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
