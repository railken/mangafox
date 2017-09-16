<?php

namespace Railken\Mangafox;
use Illuminate\Support\Collection;


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
	 * Convert the raw for request
	 *
	 * @param string $filter
	 *
	 * @return string
	 */
	public function getRawCommonFilter2($filter)
	{
		switch ($filter) {
			case '=':
				return 'eq';
			break;

			case '<':
				return 'lt';
			break;

			case '>':
				return 'gt';
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
			'is_completed' => '',
			'sort' => $builder->getSortBy()->get('field'),
			'order' => $builder->getSortBy()->get('direction') == 'desc' ? 'za' : 'az',
			'advopts' => 1
		];
		
		$params['genres'] = $builder->getGenres()->get('value')->mapWithKeys(function($item) use ($builder){
    		return [$item => $builder->getGenres()->get('filter') == 'include' ? 1 : 2];
		})->toArray();

		$params['released_method'] = $this->getRawCommonFilter2($builder->getReleasedYear()->get('filter'));
		$params['released'] = $builder->getReleasedYear()->get('value');

		$params['rating_method'] = $this->getRawCommonFilter2($builder->getRating()->get('filter'));
		$params['rating'] = $builder->getRating()->get('value');

		print_r($params);
		
		$results = $this->manager->request("GET", "/search.php", $params);

		$parser = new MangafoxSearchParser($this->manager);

		return $parser->parse($results);
	}
}