<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxResourceRequestNotFoundException extends MangafoxException
{
    public function __construct($uid)
    {
        $this->message = sprintf("The resource %s doesn't exist or is invalid", $uid);
    }
}
