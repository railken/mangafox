<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxParserDateNotSupportedException extends MangafoxException
{
    public function __construct($date)
    {
        $this->message = sprintf('Format %s not supported', $date);
    }
}
