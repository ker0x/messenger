<?php
namespace Kerox\Messenger\Model\Message\Attachment\Template\Element;

interface ElementInterface
{

    /**
     * @param string $subtitle
     * @return mixed
     */
    public function setSubtitle(string $subtitle);

    /**
     * @param string $imageUrl
     * @return mixed
     */
    public function setImageUrl(string $imageUrl);
}
