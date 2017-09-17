<?php

namespace Railken\Mangafox;
use Illuminate\Support\Collection;


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

		return $parser->parse($results);
	}
}