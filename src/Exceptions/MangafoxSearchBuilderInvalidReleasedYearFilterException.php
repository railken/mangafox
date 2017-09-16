<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidReleasedYearFilterException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('releasedYear', $value, $suggestions);
	}
}