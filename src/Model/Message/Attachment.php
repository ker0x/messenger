<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Helper\ValidatorTrait;

abstract class Attachment implements \JsonSerializable
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
    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
