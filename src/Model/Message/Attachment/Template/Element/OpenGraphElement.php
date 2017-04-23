<?php

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Common\Buttons\AbstractButtons;

class OpenGraphElement implements \JsonSerializable
{

    use ValidatorTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[]
     */
    protected $buttons = [];

    /**
     * OpenGraphElement constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->isValidUrl($url);

        $this->url = $url;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[] $buttons
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement
     */
    public function setButtons(array $buttons): OpenGraphElement
    {
        $this->isValidArray($buttons, 1);
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
            AbstractButtons::TYPE_WEB_URL,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'url' => $this->url,
            'buttons' => $this->buttons,
        ];

        return array_filter($json);
    }
}
