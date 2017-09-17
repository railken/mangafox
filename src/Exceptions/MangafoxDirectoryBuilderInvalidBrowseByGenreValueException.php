<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxDirectoryBuilderInvalidBrowseByGenreValueException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('browseBy', $value, $suggestions);
    }
}
