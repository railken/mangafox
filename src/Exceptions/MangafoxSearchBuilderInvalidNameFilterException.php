<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidNameFilterException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('name', $value, $suggestions);
	}

}