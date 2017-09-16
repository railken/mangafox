<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidSortByValueException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('sortBy', $value, $suggestions);
	}
}