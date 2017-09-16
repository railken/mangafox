<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidTypeException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('type', $value, $suggestions);
	}
}