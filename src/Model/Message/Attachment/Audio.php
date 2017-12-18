<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Audio extends File
{
    /**
     * Audio constructor.
     *
     * @param string    $url
     * @param bool|null $reusable
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($url, ?bool $reusable = null)
    {
        parent::__construct($url, $reusable, Attachment::TYPE_AUDIO);
    }
}
