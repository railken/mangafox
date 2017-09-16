<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidRatingValueException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('rating', $value, $suggestions);
	}
}