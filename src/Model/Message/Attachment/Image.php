<?php

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Image extends File
{
    /**
     * @var array
     */
    protected $allowedExtensions = ['jpg', 'png', 'gif'];

    /**
     * Image constructor.
     *
     * @param string    $url
     * @param bool|null $reusable
     */
    public function __construct(string $url, bool $reusable = null)
    {
        $this->isValidExtension($url, $this->getAllowedExtensions());

        parent::__construct($url, $reusable, Attachment::TYPE_IMAGE);
    }

    /**
     * @return array
     */
    protected function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }
}
