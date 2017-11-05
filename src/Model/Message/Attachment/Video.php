<?php

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Video extends File
{
    /**
     * Video constructor.
     *
     * @param string    $url
     * @param bool|null $reusable
     */
    public function __construct(string $url, ?bool $reusable = null)
    {
        parent::__construct($url, $reusable, Attachment::TYPE_VIDEO);
    }
}
