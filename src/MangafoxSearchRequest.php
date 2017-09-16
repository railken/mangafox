<?php

namespace Railken\Mangafox;


class MangafoxSearchRequest
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
	 * Convert the raw for request
	 *
	 * @param string $filter
	 *
	 * @return string
	 */
	public function getRawCommonFilter($filter)
	{
		switch ($filter) {
			case 'begin':
				return 'bw';
			break;

			case 'contains':
				return 'cw';
			break;

			case 'end':
				return 'ew';
			break;
		}
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


		$params = [
			'name_method' => $this->getRawCommonFilter($builder->getName()->get('filter')),
			'name' => str_replace("%20", " ", $builder->getName()->get('value')),
			'type' => $builder->getType(),
			'author_method' => $this->getRawCommonFilter($builder->getAuthor()->get('filter')),
			'author' => $builder->getAuthor()->get('value'),
			'artist_method' => $this->getRawCommonFilter($builder->getArtist()->get('filter')),
			'artist' => $builder->getArtist()->get('value'),
			'realesed_method' => 'eq',
			'realesed' => '',
			'rating_method' => 'eq',
			'rating' => '',
			'is_completed' => '',
			'advopts' => 1
		];

		$results = $this->manager->request("GET", "/search.php", $params);

		$parser = new MangafoxSearchParser($this->manager);

		return $parser->parse($results);
	}
}