<?php

namespace Kerox\Messenger\Model\Common\Buttons;

class AccountLink extends AbstractButtons
{

    /**
     * @var string
     */
    protected $url;

    /**
     * AccountLink constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        parent::__construct(self::TYPE_ACCOUNT_LINK);

        $this->isValidUrl($url);

        $this->url = $url;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'url' => $this->url,
        ];

        return $json;
    }
}
