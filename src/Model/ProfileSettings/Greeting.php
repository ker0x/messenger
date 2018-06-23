<?php

declare(strict_types=1);

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
     *
     * @throws \Exception
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
     * @param string $text
     * @param string $locale
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Model\ProfileSettings\Greeting
     */
    public static function create(string $text, string $locale = self::DEFAULT_LOCALE): self
    {
        return new self($text, $locale);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'locale' => $this->locale,
            'text' => $this->text,
        ];

        return $array;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
