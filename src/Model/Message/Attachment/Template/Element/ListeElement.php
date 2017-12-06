<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Model\Common\Button\WebUrl;

class ListeElement extends AbstractElement
{
    /**
     * @var \Kerox\Messenger\Model\Common\Button\WebUrl
     */
    protected $defaultAction;

    /**
     * @var \Kerox\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * ListeElement constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        parent::__construct($title);
    }

    /**
     * @param string $subtitle
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement
     */
    public function setSubtitle(string $subtitle): self
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @param string $imageUrl
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement
     */
    public function setImageUrl(string $imageUrl): self
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\WebUrl $defaultAction
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement
     */
    public function setDefaultAction(WebUrl $defaultAction): self
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @return ListeElement
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 1);

        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'subtitle'       => $this->subtitle,
            'image_url'      => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons'        => $this->buttons,
        ];

        return array_filter($json);
    }
}
