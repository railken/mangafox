<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidFilterException extends MangafoxInvalidArgumentException
{
    public function __construct($field, $value = null, $suggestions = [])
    {
        return parent::__construct($field, $value, $suggestions);
    }
}
