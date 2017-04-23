<?php

namespace Kerox\Messenger\Model\Common\Buttons;

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
