<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;


class MangafoxSearchParser
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
	 * Parse the response
	 *
	 * @return string $html
	 *
	 * @return MangafoxSearchResponse
	 */
	public function parse($html)
	{
		$c = HtmlPageCrawler::create($html);

		$results = $c->filter('#mangalist > ul > li')->each(function($node) {
			$bag = new Bag();
			return $bag
				->set('cover', $node->filter("img")->attr('src'));
		});

		// $response = new MangafoxSearchResponse();
	}
}