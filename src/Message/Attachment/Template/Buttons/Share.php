<?php
namespace Kerox\Messenger\Message\Attachment\Template\Buttons;

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
