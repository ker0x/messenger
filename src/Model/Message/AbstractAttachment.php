<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message;

use Kerox\Messenger\Helper\UtilityTrait;
use Kerox\Messenger\Helper\ValidatorTrait;

abstract class AbstractAttachment implements \JsonSerializable
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
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
