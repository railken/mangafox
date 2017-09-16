<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidSortByDirectionException extends MangafoxException
{

	public function __construct($value)
	{
		$this->message = sprintf("sortBy expects 'asc' or 'desc', detected %s", $value);
	}
}