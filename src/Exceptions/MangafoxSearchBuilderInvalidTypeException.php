<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidTypeException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('type', $value, $suggestions);
    }
}
