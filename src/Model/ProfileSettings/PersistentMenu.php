<?php
namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Buttons\AbstractButtons;

class PersistentMenu implements ProfileSettingsInterface, \JsonSerializable
{

    use ValidatorTrait;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var bool
     */
    protected $composerInputDisabled = false;

    /**
     * @var \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[]
     */
    protected $buttons = [];

    /**
     * PersistentMenu constructor.
     *
     * @param string $locale
     */
    public function __construct(string $locale = self::DEFAULT_LOCALE)
    {
        if ($locale !== self::DEFAULT_LOCALE) {
            $this->isValidLocale($locale);
        }

        $this->locale = $locale;
    }

    /**
     * @param bool $composerInputDisabled
     * @return \Kerox\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function setComposerInputDisabled(bool $composerInputDisabled): PersistentMenu
    {
        $this->composerInputDisabled = $composerInputDisabled;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[] $buttons
     * @return \Kerox\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function addButtons(array $buttons): PersistentMenu
    {
        $this->isValidArray($buttons, 5);
        $this->isValidButtons($buttons);

        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @param array $buttons
     */
    private function isValidButtons(array $buttons)
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
        $json = [
            'locale' => $this->locale,
            'composer_input_disabled' => $this->composerInputDisabled,
            'call_to_actions' => $this->buttons,
        ];

        return array_filter($json);
    }
}
