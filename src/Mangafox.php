<?php

namespace Railken\Mangafox;

class Mangafox extends MangaReader
{

	/**
	 * Base url mangafox
	 *
	 * @var string
	 */
	protected $url = 'http://mangafox.me/';

	/**
	 * List of genres available on mangafox
	 *
	 * @var string[]
	 */
	protected $genres = [
		'Action',
		'Adult',
		'Adventure',
		'Comedy',
		'Doujinshi',
		'Drama',
		'Ecchi',
		'Fantasy',
		'Gender Bender',
		'Harem',
		'Historical',
		'Horror',
		'Josei',
		'Martial Arts',
		'Mature',
		'Mecha',
		'Mystery',
		'One Shot',
		'Psychological',
		'Romance',
		'School Life',
		'Sci-fi',
		'Seinen',
		'Shoujo',
		'Shoujo Ai',
		'Shounen',
		'Shounen Ai',
		'Slice of Life',
		'Smut',
		'Sports',
		'Supernatural',
		'Tragedy',
		'Webtoons',
		'Yaoi',
		'Yuri'
	];

	/**
	 * Perform a search
	 *
	 * @return MangaFoxSearchBuilder
	 */
	public function search()
	{
		return new MangafoxSearchBuilder($this);
	}

	/**
	 * Retrieve genres available on mangafox
	 *
	 * @return array
	 */
	public function getGenres()
	{
		return $this->genres;
	}

}