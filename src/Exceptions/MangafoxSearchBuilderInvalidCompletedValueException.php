<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidCompletedValueException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('completed', $value, $suggestions);
    }
}
