<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidGenresValueException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('genres', implode(', ', $value), $suggestions);
    }
}
