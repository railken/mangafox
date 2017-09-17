<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;
use Illuminate\Support\Collection;

class MangafoxResourceBuilder
{

	/**
	 * @var Mangafox
	 */
	protected $manager;

	/**
	 * @var string
	 */
	protected $uid;

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
	 * The uid 
	 *
	 * @param string $uid
	 *
	 * @return $this
	 */
	public function uid($uid)
	{
	
		$this->uid = $uid;

		return $this;
	}

	/**
	 * Return uid
	 *
	 * @return string
	 */
	public function getUid()
	{
		return $this->uid;
	}

	/**
	 * Send request
	 *
	 * @return Response
	 */
	public function get()
	{

		$request = new MangafoxResourceRequest($this->manager);

		return $request->send($this);
	}
}