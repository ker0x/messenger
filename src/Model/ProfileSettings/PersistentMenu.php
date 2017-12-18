<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Button\AbstractButton;

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
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * PersistentMenu constructor.
     *
     * @param string $locale
     *
     * @throws \InvalidArgumentException
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
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function setComposerInputDisabled(bool $composerInputDisabled): self
    {
        $this->composerInputDisabled = $composerInputDisabled;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function addButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 5);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->buttons = $buttons;

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
        $array = [
            'locale'                  => $this->locale,
            'composer_input_disabled' => $this->composerInputDisabled,
            'call_to_actions'         => $this->buttons,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
