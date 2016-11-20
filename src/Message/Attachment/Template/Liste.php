<?php
namespace Kerox\Messenger\Message\Attachment\Template;

use Kerox\Messenger\Message\Attachment\Template;

class Liste extends Template
{

    const TOP_ELEMENT_STYLE_LARGE = 'large';
    const TOP_ELEMENT_STYLE_COMPACT = 'compact';

    /**
     * @var string
     */
    protected $topElementStyle;

    /**
     * @var \Kerox\Messenger\Message\Attachment\Template\Element\ListeElement[]
     */
    protected $elements = [];

    /**
     * @var \Kerox\Messenger\Message\Attachment\Template\Buttons\AbstractButtons[]
     */
    protected $buttons = [];

    /**
     * Liste constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 4, 2);

        $this->elements = $elements;
    }

    /**
     * @param string $topElementStyle
     * @return Liste
     */
    public function setTopElementStyle(string $topElementStyle): Liste
    {
        $this->isValidTopElementStyle($topElementStyle);
        $this->topElementStyle = $topElementStyle;

        return $this;
    }

    /**
     * @param string $topElementStyle
     * @return void
     * @throws \InvalidArgumentException
     */
    private function isValidTopElementStyle(string $topElementStyle)
    {
        $allowedTopElementStyle = $this->getAllowedTopElementStyle();
        if (!in_array($topElementStyle, $allowedTopElementStyle)) {
            throw new \InvalidArgumentException('$topElementStyle is not a valid');
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
     * @param \Kerox\Messenger\Message\Attachment\Template\Buttons\AbstractButtons[] $buttons
     * @return \Kerox\Messenger\Message\Attachment\Template\Liste
     * @internal param array $buttons
     */
    public function setButtons(array $buttons): Liste
    {
        $this->isValidArray($buttons, 1);
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $payload = [
            'template_type' => Template::TYPE_LIST,
            'top_element_style' => $this->topElementStyle,
            'elements' => $this->elements,
            'buttons' => $this->buttons,
        ];

        $json = parent::jsonSerialize();
        $json += [
            'payload' => array_filter($payload),
        ];

        return $json;
    }
}