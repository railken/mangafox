<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxDirectoryBuilderInvalidBrowseByInitialValueException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('browseBy', $value, $suggestions);
    }
}
