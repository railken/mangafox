<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidArtistFilterException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('artist', $value, $suggestions);
	}

}