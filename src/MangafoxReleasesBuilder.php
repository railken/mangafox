<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;
use Illuminate\Support\Collection;

class MangafoxReleasesBuilder
{

	/**
	 * @var Mangafox
	 */
	protected $manager;

	/**
	 * @var integer
	 */
	protected $page = 1;

	/**
	 * Construct
	 *
	 * @param Mangafox $manager
	 */
	public function __construct($manager)
	{
		$this->manager = $manager;
	}

	/**
	 * The page 
	 *
	 * @param string $page
	 *
	 * @return $this
	 */
	public function page($page)
	{
		$this->page = $page;
		
		return $this;
	}

	/**
	 * Return page
	 *
	 * @return string
	 */
	public function getPage()
	{
		return $this->page;
	}

	/**
	 * Send request
	 *
	 * @return Response
	 */
	public function get()
	{
		$request = new MangafoxReleasesRequest($this->manager);

		return $request->send($this);
	}
}