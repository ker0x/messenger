<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

class Nested extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons;

    /**
     * Nested constructor.
     *
     * @param string                                                $title
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $title, array $buttons)
    {
        parent::__construct(self::TYPE_NESTED);

        $this->isValidString($title, 20);
        $this->isValidArray($buttons, 5);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->title = $title;
        $this->buttons = $buttons;
    }

    /**
     * @param string $title
     * @param array  $buttons
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Common\Button\Nested
     */
    public static function create(string $title, array $buttons): self
    {
        return new self($title, $buttons);
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton $button
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Common\Button\Nested
     */
    public function addButton(AbstractButton $button): self
    {
        $this->isValidButtons([$button], $this->getAllowedButtonsType());

        $this->buttons[] = $button;

        return $this;
    }

    /**
     * @return array
     */
    protected function getAllowedButtonsType(): array
    {
        return [
            AbstractButton::TYPE_WEB_URL,
            AbstractButton::TYPE_POSTBACK,
            AbstractButton::TYPE_NESTED,
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'title'           => $this->title,
            'call_to_actions' => $this->buttons,
        ];

        return $array;
    }
}
