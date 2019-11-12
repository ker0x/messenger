<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Button\AbstractButton;

class OpenGraphElement implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * OpenGraphElement constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $url)
    {
        $this->isValidUrl($url);

        $this->url = $url;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement
     */
    public static function create(string $url): self
    {
        return new self($url);
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 1);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->buttons = $buttons;

        return $this;
    }

    protected function getAllowedButtonsType(): array
    {
        return [
            AbstractButton::TYPE_WEB_URL,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'url' => $this->url,
            'buttons' => $this->buttons,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
