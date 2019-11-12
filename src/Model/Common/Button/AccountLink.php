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
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function __construct(string $url)
    {
        parent::__construct(self::TYPE_ACCOUNT_LINK);

        $this->isValidUrl($url);

        $this->url = $url;
    }

    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Model\Common\Button\AccountLink
     */
    public static function create(string $url): self
    {
        return new self($url);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'url' => $this->url,
        ];

        return $array;
    }
}
