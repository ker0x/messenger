<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;

class Share extends AbstractButton
{
    use UtilityTrait;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate|null
     */
    protected $content;

    /**
     * Share constructor.
     *
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate|null $content
     */
    public function __construct(?GenericTemplate $content = null)
    {
        parent::__construct(self::TYPE_SHARE);

        $this->content = $content;
    }

    /**
     * @param \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate|null $content
     *
     * @return \Kerox\Messenger\Model\Common\Button\Share
     */
    public static function create(?GenericTemplate $content = null): self
    {
        return new self($content);
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
