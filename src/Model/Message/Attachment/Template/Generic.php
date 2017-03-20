<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class Generic extends Template
{

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[]
     */
    protected $elements;

    /**
     * Generic constructor.
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement[] $elements
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 10);

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
                'template_type' => Template::TYPE_GENERIC,
                'elements' => $this->elements,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
