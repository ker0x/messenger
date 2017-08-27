<?php

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message\Attachment\Template\Generic;

class Share extends AbstractButton
{
    use UtilityTrait;

    /**
     * @var null|\Kerox\Messenger\Model\Message\Attachment\Template\Generic
     */
    protected $content;

    /**
     * Share constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\Generic $content
     */
    public function __construct(Generic $content = null)
    {
        parent::__construct(self::TYPE_SHARE);

        $this->content = $content;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'share_contents' => [
                'attachment' => $this->content,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
