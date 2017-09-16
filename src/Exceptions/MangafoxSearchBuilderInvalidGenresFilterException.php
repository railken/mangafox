<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidGenresFilterException extends MangafoxSearchBuilderInvalidArgumentException
{
	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('genres', $value, $suggestions);
	}

}