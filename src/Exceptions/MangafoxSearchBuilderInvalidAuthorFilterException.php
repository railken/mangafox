<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidAuthorFilterException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('author', $value, $suggestions);
	}

}