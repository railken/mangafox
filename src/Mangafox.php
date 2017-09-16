<?php

namespace Railken\Mangafox;

class Mangafox extends MangaReader
{

	protected $url = 'http://mangafox.me/';

	public function search()
	{
		return new MangafoxSearchBuilder($this);
	}

}