<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Message\Attachment;

use Kerox\Messenger\Model\Message\Attachment;

class File extends Attachment
{
    /**
     * @var null|string
     */
    protected $url;

    /**
     * @var null|bool
     */
    protected $reusable;

    /**
     * @var null|string
     */
    protected $attachmentId;

    /**
     * File constructor.
     *
     * @param string    $url
     * @param bool|null $reusable
     * @param string    $type
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct($url, ?bool $reusable = null, $type = Attachment::TYPE_FILE)
    {
        parent::__construct($type);

        if ($this->isAttachmentId($url)) {
            $this->attachmentId = $url;
        } else {
            $this->isValidUrl($url);
            $this->url = $url;
        }

        $this->reusable = $reusable;
    }

    /**
     * @param string    $url
     * @param bool|null $reusable
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Message\Attachment\File
     */
    public static function create($url, ?bool $reusable = null): self
    {
        return new self($url, $reusable);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isAttachmentId($value): bool
    {
        return (bool) preg_match('/^[\d]+$/', $value);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'url' => $this->url,
                'is_reusable' => $this->reusable,
                'attachment_id' => $this->attachmentId,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
