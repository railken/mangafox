<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidReleasedYearValueException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		$this->message = sprintf("invalid value '%s' for method %s(), expects: 4 digits year (e.g. 2017)", "releasedYear", $field, $suggestions);
	}
}