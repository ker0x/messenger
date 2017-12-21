<?php

declare(strict_types=1);

namespace Kerox\Messenger\Model\Common\Button;

class AccountLink extends AbstractButton
{
    /**
     * @var string
     */
    protected $url;

    /**
     * AccountLink constructor.
     *
     * @param string $url
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $url)
    {
        parent::__construct(self::TYPE_ACCOUNT_LINK);

        $this->isValidUrl($url);

        $this->url = $url;
    }

    /**
     * @param string $url
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Model\Common\Button\AccountLink
     */
    public static function create(string $url): self
    {
        return new self($url);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'url' => $this->url,
        ];

        return $array;
    }
}
