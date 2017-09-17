<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxScanBuilderInvalidUrlException extends MangafoxException
{
    public function __construct($url, $suggestion)
    {
        $this->message = sprintf("invalid value '%s' for method %s(), e.g (%s)", $url, 'url', $suggestion);
    }
}
