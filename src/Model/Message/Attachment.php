<?php
namespace Kerox\Messenger\Model\Message;

use Kerox\Messenger\Helper\ValidatorTrait;

class Attachment implements \JsonSerializable
{

    use ValidatorTrait;

    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';
    const TYPE_TEMPLATE = 'template';

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
