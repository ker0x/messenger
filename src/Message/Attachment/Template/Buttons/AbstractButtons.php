<?php
namespace Kerox\Messenger\Message\Attachment\Template\Buttons;

use Kerox\Messenger\ValidatorTrait;

abstract class AbstractButtons implements \JsonSerializable
{

    use ValidatorTrait;

    const TYPE_POSTBACK = 'postback';
    const TYPE_PHONE_NUMBER = 'phone_number';
    const TYPE_WEB_URL = 'web_url';
    const TYPE_SHARE = 'element_share';
    const TYPE_PAYMENT = 'payment';
    const TYPE_ACCOUNT_LINK = 'account_link';
    const TYPE_ACCOUNT_UNLINK = 'account_unlink';

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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}