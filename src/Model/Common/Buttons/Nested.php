<?php

namespace Kerox\Messenger\Model\Common\Buttons;

class Nested extends AbstractButtons
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[]
     */
    protected $buttons;

    /**
     * Nested constructor.
     *
     * @param string $title
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[] $buttons
     */
    public function __construct(string $title, array $buttons)
    {
        parent::__construct(self::TYPE_NESTED);

        $this->isValidString($title, 20);
        $this->isValidArray($buttons, 5);
        $this->isValidButton($buttons);

        $this->title = $title;
        $this->buttons = $buttons;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons $button
     * @return \Kerox\Messenger\Model\Common\Buttons\Nested
     */
    public function addButton(AbstractButtons $button): Nested
    {
        $this->isValidButton([$button]);

        $this->buttons[] = $button;

        return $this;
    }

    /**
     * @param array $buttons
     */
    private function isValidButton(array $buttons)
    {
        $allowedButtonsType = $this->getAllowedButtonsType();

        /** @var AbstractButtons $button */
        foreach ($buttons as $button) {
            if (!in_array($button->getType(), $allowedButtonsType)) {
                throw new \InvalidArgumentException('Buttons can only be an instance of WebUrl, PostBack or Nested');
            }
        }
    }

    /**
     * @return array
     */
    private function getAllowedButtonsType(): array
    {
        return [
            AbstractButtons::TYPE_WEB_URL,
            AbstractButtons::TYPE_POSTBACK,
            AbstractButtons::TYPE_NESTED,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'title' => $this->title,
            'call_to_actions' => $this->buttons,
        ];

        return $json;
    }
}
