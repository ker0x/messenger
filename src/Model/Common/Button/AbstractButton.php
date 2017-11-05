<?php

namespace Kerox\Messenger\Model\Common\Button;

use Kerox\Messenger\Helper\ValidatorTrait;

abstract class AbstractButton implements \JsonSerializable
{
    use ValidatorTrait;

    public const TYPE_POSTBACK = 'postback';
    public const TYPE_PHONE_NUMBER = 'phone_number';
    public const TYPE_WEB_URL = 'web_url';
    public const TYPE_SHARE = 'element_share';
    public const TYPE_PAYMENT = 'payment';
    public const TYPE_ACCOUNT_LINK = 'account_link';
    public const TYPE_ACCOUNT_UNLINK = 'account_unlink';
    public const TYPE_NESTED = 'nested';

    /**
     * @var string
     */
    private $type;

    /**
     * AbstractButton constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
