<?php

namespace Kerox\Messenger\Model\Message;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Helper\ValidatorTrait;

class Attachment implements \JsonSerializable
{
    use UtilityTrait;
    use ValidatorTrait;

    protected const TYPE_IMAGE = 'image';
    protected const TYPE_AUDIO = 'audio';
    protected const TYPE_VIDEO = 'video';
    protected const TYPE_FILE = 'file';
    protected const TYPE_TEMPLATE = 'template';

    /**
     * @var string
     */
    protected $type;

    /**
     * Attachment constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'type' => $this->type,
        ];

        return $json;
    }
}
