<?php
namespace Kerox\Messenger\Message\Attachment\Template;

interface AirlineInterface
{

    /**
     * @param string $themeColor
     * @return mixed
     */
    public function setThemeColor(string $themeColor);
}