<?php

namespace Railken\Mangafox;
use Illuminate\Support\Collection;

use Railken\Mangafox\Exceptions as Exceptions;

class MangafoxResourceRequest
{
	
	/*
	 * @var Mangafox
	 */
	protected $manager;

	/**
	 * Constructor
	 *
	 * @param Mangafox $manager
	 */
	public function __construct($manager)
	{
		$this->manager = $manager;
	}	

	/**
	 * Send the request for the research
	 *
	 * @param MangafoxSearchBuilder $builder
	 *
	 * @return MangafoxSearchResponse
	 */
	public function send($builder)
	{

		$results = $this->manager->request("GET", "/manga/{$builder->getUid()}", []);

		$parser = new MangafoxResourceParser($this->manager);

		try {

			return $parser->parse($results);
		
		} catch (Exceptions\MangafoxResourceParserInvalidUrlException $e) {

			throw new Exceptions\MangafoxResourceRequestNotFoundException($builder->getUid());
		}
	}
}