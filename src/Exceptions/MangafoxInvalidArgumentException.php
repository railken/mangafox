<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxInvalidArgumentException extends MangafoxException
{
    public function __construct($field, $value = null, $suggestions = [])
    {
        $this->message = sprintf("invalid value '%s' for method %s(), expects: ".implode(', ', $suggestions).'', $value, $field);
    }
}
