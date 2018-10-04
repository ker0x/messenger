<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Audio extends File
{
    /**
     * Audio constructor.
     *
     * @param string|int $url
     * @param bool|null  $reusable
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct($url, ?bool $reusable = null)
    {
        parent::__construct($url, $reusable, Attachment::TYPE_AUDIO);
    }

    /**
     * @param string|int $url
     * @param bool|null  $reusable
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\File
     */
    public static function create($url, ?bool $reusable = null): File
    {
        return new self($url, $reusable);
    }
}
