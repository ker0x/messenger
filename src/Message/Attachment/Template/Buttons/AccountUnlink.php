<?php
namespace Kerox\Messenger\Message\Attachment\Template\Buttons;

class AccountUnlink extends AbstractButtons
{

    /**
     * AccountUnlink constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_ACCOUNT_UNLINK);
    }
}
