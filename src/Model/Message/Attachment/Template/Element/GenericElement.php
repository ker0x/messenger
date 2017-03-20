<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Model\Common\Buttons\WebUrl;

class GenericElement extends AbstractElement
{

    /**
     * @var \Kerox\Messenger\Model\Common\Buttons\WebUrl
     */
    protected $defaultAction;

    /**
     * @var null|\Kerox\Messenger\Model\Common\Buttons\AbstractButtons[]
     */
    protected $buttons = [];

    /**
     * Element constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        parent::__construct($title);
    }

    /**
     * @param string $subtitle
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setSubtitle(string $subtitle): GenericElement
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @param string $imageUrl
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setImageUrl(string $imageUrl): GenericElement
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Buttons\WebUrl $defaultAction
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setDefaultAction(WebUrl $defaultAction): GenericElement
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Buttons\AbstractButtons[] $buttons
     * @return \Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement
     */
    public function setButtons(array $buttons): GenericElement
    {
        $this->isValidArray($buttons, 3);
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
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons' => $this->buttons,
        ];

        return array_filter($json);
    }
}
