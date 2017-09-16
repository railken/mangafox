<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidGenresValueException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('genres', implode(", ", $value), $suggestions);
	}
}