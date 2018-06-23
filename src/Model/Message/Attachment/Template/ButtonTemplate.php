<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Message\Attachment\Template;

class ButtonTemplate extends Template
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
     *
     * @throws \InvalidArgumentException
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
     * @param string $text
     * @param array  $buttons
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate
     */
    public static function create(string $text, array $buttons): self
    {
        return new self($text, $buttons);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => Template::TYPE_BUTTON,
                'text' => $this->text,
                'buttons' => $this->buttons,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
