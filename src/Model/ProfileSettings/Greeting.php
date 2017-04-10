<?php

namespace Kerox\Messenger\Model\ProfileSettings;

use Kerox\Messenger\Helper\ValidatorTrait;

class Greeting implements ProfileSettingsInterface, \JsonSerializable
{

    use ValidatorTrait;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Greeting constructor.
     *
     * @param string $text
     * @param string $locale
     */
    public function __construct(string $text, string $locale = self::DEFAULT_LOCALE)
    {
        $this->isValidString($text, 160);

        if ($locale !== self::DEFAULT_LOCALE) {
            $this->isValidLocale($locale);
        }

        $this->text = $text;
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'locale' => $this->locale,
            'text' => $this->text,
        ];

        return $json;
    }
}
