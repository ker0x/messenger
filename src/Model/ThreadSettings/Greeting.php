<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings;

class Greeting extends ThreadSettings
{

    /**
     * @var string
     */
    protected $text;

    /**
     * Greeting constructor.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        parent::__construct(ThreadSettings::TYPE_GREETING);

        $this->isValidString($text, 160);

        $this->text = $text;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'greeting' => [
                'text' => $this->text,
            ],
        ];

        return $json;
    }
}
