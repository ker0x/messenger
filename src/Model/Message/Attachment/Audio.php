<?php

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Audio extends File
{

    /**
     * Audio constructor.
     *
     * @param string $url
     * @param bool|null $reusable
     */
    public function __construct($url, bool $reusable = null)
    {
        parent::__construct($url, $reusable, Attachment::TYPE_AUDIO);
    }
}
