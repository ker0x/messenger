<?php
namespace Kerox\Messenger\Model\Common\Buttons;

class Share extends AbstractButtons
{

    /**
     * Share constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_SHARE);
    }
}
