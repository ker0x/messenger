<?php

namespace Kerox\Messenger\Model\Common\Button;

class AccountUnlink extends AbstractButton
{

    /**
     * AccountUnlink constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_ACCOUNT_UNLINK);
    }
}
