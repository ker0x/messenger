<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class Share extends AbstractButton
{
    use UtilityTrait;

    /**
     * @var \Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate|null
     */
    protected $content;

    /**
     * Share constructor.
     */
    public function __construct(?GenericTemplate $content = null)
    {
        parent::__construct(self::TYPE_SHARE);

        $this->content = $content;
    }

    /**
     * @return \Kerox\Messenger\Model\Common\Button\Share
     */
    public static function create(?GenericTemplate $content = null): self
    {
        return new self($content);
    }

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
