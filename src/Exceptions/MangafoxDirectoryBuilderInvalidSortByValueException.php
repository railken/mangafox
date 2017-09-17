<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxDirectoryBuilderInvalidSortByValueException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('sortBy', $value, $suggestions);
    }
}
