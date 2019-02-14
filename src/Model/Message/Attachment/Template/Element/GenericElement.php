<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Model\Common\Button\WebUrl;

class GenericElement extends AbstractElement
{
    /**
     * @var \Kerox\Messenger\Model\Common\Button\WebUrl
     */
    protected $defaultAction;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]|null
     */
    protected $buttons = [];

    /**
     * @param string $title
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public static function create(string $title): self
    {
        return new self($title);
    }

    /**
     * @param string $subtitle
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setSubtitle(string $subtitle): self
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @param string $imageUrl
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setImageUrl(string $imageUrl): self
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\WebUrl $defaultAction
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setDefaultAction(WebUrl $defaultAction): self
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 3);

        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons' => $this->buttons,
        ];

        return array_filter($array);
    }
}
