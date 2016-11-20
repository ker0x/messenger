<?php
namespace Kerox\Messenger\Message\Attachment\Template\Element;

use Kerox\Messenger\Message\Attachment\Template\Buttons\WebUrl;

class ListeElement extends AbstractElement
{

    /**
     * @var \Kerox\Messenger\Message\Attachment\Template\Buttons\WebUrl
     */
    protected $defaultAction;

    /**
     * @var \Kerox\Messenger\Message\Attachment\Template\Buttons\AbstractButtons[]
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
     * @param \Kerox\Messenger\Message\Attachment\Template\Buttons\WebUrl $defaultAction
     * @return \Kerox\Messenger\Message\Attachment\Template\Element\ListeElement
     */
    public function setDefaultAction(WebUrl $defaultAction): ListeElement
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * @param \Kerox\Messenger\Message\Attachment\Template\Buttons\AbstractButtons[] $buttons
     * @return ListeElement
     */
    public function setButtons(array $buttons): ListeElement
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
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons' => $this->buttons,
        ];

        return array_filter($json);
    }
}
