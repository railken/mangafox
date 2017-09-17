<?php

namespace Railken\Mangafox\Exceptions;

class MangafoxResourceParserDateNotSupportedException extends MangafoxException
{

	public function __construct($date)
	{
		$this->message = sprintf("Format %s not supported", $date);
	}
}