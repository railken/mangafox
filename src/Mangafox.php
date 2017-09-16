<?php

namespace Railken\Mangafox;

class Mangafox extends MangaReader
{

	protected $url = 'http://mangafox.me/';

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

	public function search()
	{
		return new MangafoxSearchBuilder($this);
	}

	public function getGenres(){
		return $this->genres;
	}

}