<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;

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
     * @param null|\Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate $content
     */
    public function __construct(?GenericTemplate $content = null)
    {
        parent::__construct(self::TYPE_SHARE);

        $this->content = $content;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'share_contents' => [
                'attachment' => $this->content,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
