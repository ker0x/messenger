<?php
namespace Kerox\Messenger\Message\Attachment;

use Kerox\Messenger\Message\Attachment;

class Image extends File
{

    /**
     * @var array
     */
    protected $allowedExtension = ['jpg', 'png', 'gif'];

    /**
     * Image constructor.
     *
     * @param string $url
     * @param bool|null $reusable
     */
    public function __construct(string $url, bool $reusable = null)
    {
        $this->isValidExtension($url, $this->allowedExtension);

        parent::__construct($url, $reusable, Attachment::TYPE_IMAGE);
    }
}