<?php

namespace Railken\Mangafox\Exceptions;


class MangafoxSearchBuilderInvalidSortByDirectionException extends MangafoxSearchBuilderInvalidArgumentException
{

	public function __construct($value = null, $suggestions = [])
	{
		return parent::__construct('sortBy', $value, $suggestions);
	}
}