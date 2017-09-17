<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;

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
		$node = HtmlPageCrawler::create($html);

		$bag = new Bag();

		$bag->set('pages', $node->filter("div#nav > ul > li:nth-last-child(2)")->text());
		$bag->set('results', new Collection($node->filter('#mangalist > ul > li')->each(function($node) {
			$bag = new Bag();

			$title = $node->filter("a.title");

			return $bag
				->set('id', basename($title->attr('rel')))
				->set('uid', basename($title->attr('href')))
				->set('name', $title->html())
				->set('url', $title->attr('href'))
				->set('cover', $node->filter("img")->attr('src'))
				->set('latest', $node->filter("p.latest > a")->attr('href'))
				->set('genres', explode(", ", $node->filter("p.info")->attr('title')))
				->set('rate', $node->filter("span.rate")->html())
				;
		})));
		

		$bag->set('page', $node->filter("li.red")->text());

		return $bag;

		// print_r($results);
		// $response = new MangafoxSearchResponse();
	}
}