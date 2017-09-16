<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidFilterException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($field, $value = null, $suggestions = [])
	{
		return parent::__construct($field, $value, $suggestions);
	}

}