<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class Button extends Template
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons;

    /**
     * Buttons constructor.
     *
     * @param string                                                $text
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     */
    public function __construct(string $text, array $buttons)
    {
        parent::__construct();

        $this->isValidString($text, 320);
        $this->isValidArray($buttons, 3);

        $this->text = $text;
        $this->buttons = $buttons;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'template_type' => Template::TYPE_BUTTON,
                'text'          => $this->text,
                'buttons'       => $this->buttons,
            ]
        ];

        return $this->arrayFilter($json);
    }
}
