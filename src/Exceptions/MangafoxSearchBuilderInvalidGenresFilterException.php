<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidGenresFilterException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('genres', $value, $suggestions);
    }
}
