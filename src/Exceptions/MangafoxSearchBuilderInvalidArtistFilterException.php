<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidArtistFilterException extends MangafoxInvalidArgumentException
{
    public function __construct($value = null, $suggestions = [])
    {
        return parent::__construct('artist', $value, $suggestions);
    }
}
