<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\Common\Buttons\AbstractButtons;
use Kerox\Messenger\Model\ThreadSettings;

/**
 * @deprecated since 1.2.0 and will be remove in 1.3.0.
 * @see \Kerox\Messenger\Model\ProfileSettings\PersistentMenu
 */
class Menu extends ThreadSettings
{

    /**
     * @var \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[]
     */
    protected $buttons;

    /**
     * Menu constructor.
     *
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[] $buttons
     */
    public function __construct(array $buttons)
    {
        parent::__construct(ThreadSettings::TYPE_CALL_TO_ACTIONS, ThreadSettings::STATE_EXISTING_THREAD);

        $this->isValidArray($buttons, 5);
        $this->isValidButton($buttons);

        $this->buttons = $buttons;
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
                throw new \InvalidArgumentException('Buttons can only be an instance of WebUrl or PostBack');
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
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'call_to_actions' => $this->buttons,
        ];

        return $json;
    }
}
