<?php

namespace Kerox\Messenger\Model\Common\Button;

class Postback extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $payload;

    /**
     * Postback constructor.
     *
     * @param string $title
     * @param string $payload
     */
    public function __construct(string $title, string $payload)
    {
        parent::__construct(self::TYPE_POSTBACK);

        $this->isValidString($title, 20);
        $this->isValidString($payload, 1000);

        $this->title = $title;
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'title'   => $this->title,
            'payload' => $this->payload,
        ];

        return $json;
    }
}
