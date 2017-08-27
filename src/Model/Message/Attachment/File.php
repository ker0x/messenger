<?php

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
     */
    public function __construct($url, bool $reusable = null, $type = Attachment::TYPE_FILE)
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
     * @param $value
     *
     * @return bool
     */
    private function isAttachmentId($value): bool
    {
        return preg_match('/^[\d]+$/', $value);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'payload' => [
                'url'           => $this->url,
                'is_reusable'   => $this->reusable,
                'attachment_id' => $this->attachmentId,
            ],
        ];

        return $this->arrayFilter($json);
    }
}
