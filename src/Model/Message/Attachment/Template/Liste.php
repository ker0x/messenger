<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class Liste extends Template
{
    const TOP_ELEMENT_STYLE_LARGE = 'large';

    const TOP_ELEMENT_STYLE_COMPACT = 'compact';

    /**
     * @var string
     */
    protected $topElementStyle;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement[]
     */
    protected $elements = [];

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * Liste constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement[] $elements
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 4, 2);

        $this->elements = $elements;
    }

    /**
     * @param string $topElementStyle
     *
     * @return Liste
     */
    public function setTopElementStyle(string $topElementStyle): Liste
    {
        $this->isValidTopElementStyle($topElementStyle);

        $this->topElementStyle = $topElementStyle;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Liste
     */
    public function setButtons(array $buttons): Liste
    {
        $this->isValidArray($buttons, 1);

        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @param string $topElementStyle
     *
     * @throws \InvalidArgumentException
     */
    private function isValidTopElementStyle(string $topElementStyle)
    {
        $allowedTopElementStyle = $this->getAllowedTopElementStyle();
        if (!in_array($topElementStyle, $allowedTopElementStyle, true)) {
            throw new \InvalidArgumentException('$topElementStyle must be either ' . implode(', ', $allowedTopElementStyle));
        }
    }

    /**
     * @return array
     */
    private function getAllowedTopElementStyle(): array
    {
        return [
            self::TOP_ELEMENT_STYLE_LARGE,
            self::TOP_ELEMENT_STYLE_COMPACT,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type'     => Template::TYPE_LIST,
                'top_element_style' => $this->topElementStyle,
                'elements'          => $this->elements,
                'buttons'           => $this->buttons,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
