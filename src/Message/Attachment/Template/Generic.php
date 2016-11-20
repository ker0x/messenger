<?php
namespace Kerox\Messenger\Message\Attachment\Template;

use Kerox\Messenger\Message\Attachment\Template;

class Generic extends Template
{

    /**
     * @var \Kerox\Messenger\Message\Attachment\Template\Element\GenericElement[]
     */
    protected $elements;

    /**
     * Generic constructor.
     * @param \Kerox\Messenger\Message\Attachment\Template\Element\GenericElement[] $elements
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
        $payload = [
            'template_type' => Template::TYPE_GENERIC,
            'elements' => $this->elements,
        ];

        $json = parent::jsonSerialize();
        $json += [
            'payload' => array_filter($payload),
        ];

        return $json;
    }
}