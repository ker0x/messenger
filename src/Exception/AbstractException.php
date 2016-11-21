<?php
namespace Kerox\Messenger\Exception;

use Exception;

abstract class AbstractException extends Exception
{

    public static function invalidSenderAction()
    {
        return new static("");
    }
}
