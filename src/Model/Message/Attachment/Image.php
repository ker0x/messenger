<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class Image extends File
{
    protected const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif'];

    /**
     * Image constructor.
     *
     * @param string    $url
     * @param bool|null $reusable
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, ?bool $reusable = null)
    {
        $this->isValidExtension($url, $this->getAllowedExtensions());

        parent::__construct($url, $reusable, Attachment::TYPE_IMAGE);
    }

    /**
     * @param string    $url
     * @param bool|null $reusable
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\File
     */
    public static function create(string $url, ?bool $reusable = null): File
    {
        return new self($url, $reusable);
    }

    /**
     * @return array
     */
    protected function getAllowedExtensions(): array
    {
        return self::ALLOWED_EXTENSIONS;
    }
}
