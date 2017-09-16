<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxSearchBuilderInvalidFilterException extends MangafoxException
{

	public function __construct($attribute)
	{
		$this->message = sprintf("The first attribute of method {$attribute} requires the following values: contains, begin, end");
	}
}