<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\AbstractAttachment;

class Video extends File
{
    /**
     * Video constructor.
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, ?bool $reusable = null)
    {
        parent::__construct($url, $reusable, AbstractAttachment::TYPE_VIDEO);
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\File
     */
    public static function create(string $url, ?bool $reusable = null): File
    {
        return new self($url, $reusable);
    }
}
