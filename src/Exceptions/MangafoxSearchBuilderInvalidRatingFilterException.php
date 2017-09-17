<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidRatingFilterException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('rating', $value, $suggestions);
    }
}
