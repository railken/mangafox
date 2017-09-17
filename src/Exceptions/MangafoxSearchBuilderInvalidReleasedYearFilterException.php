<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidReleasedYearFilterException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('releasedYear', $value, $suggestions);
    }
}
