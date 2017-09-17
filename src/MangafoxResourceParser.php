<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;
use DateTime;
use Railken\Mangafox\Exceptions\MangafoxResourceParserDateNotSupported;
use Railken\Mangafox\Traits\ParseDateTrait;

class MangafoxResourceParser
{
	use ParseDateTrait;
	
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

		$head = $node->filter("head");
		$title = $node->filter("div#title");


		if (!$head->filter("[property='og:url']")->getNode(0)) {
			throw new Exceptions\MangafoxResourceParserInvalidUrlException();
		}

		$bag = new Bag();
		$bag
			->set('url', $head->filter("[property='og:url']")->attr('content'))
			->set('uid', basename($bag->get('url')))
			->set('cover', $head->filter("[property='og:image']")->attr('content'))
			->set('description', $head->filter("[property='og:description']")->attr('content'))
			->set('aliases', explode("; ", $title->filter("h3")->text()))
			->set('released_year', $title->filter("[valign='top']:nth-child(1) > a")->html())
			->set('author', $title->filter("[valign='top']:nth-child(2) > a")->html())
			->set('artist', $title->filter("[valign='top']:nth-child(3) > a")->html())
			->set('genres', explode(", ", trim($title->filter("[valign='top']:nth-child(4)")->text())))
			->set('status', explode(",", trim($node->filter("div.data > span")->text()))[0])
			->set('volumes', new Collection($node->filter("ul.chlist")->each(function ($node) {


				$chapters = $node->filter("li")->each(function ($node) {


					$bag = new Bag();
					$bag->set('url', $node->filter("a.tips")->attr('href'));
					$bag->set('title', $node->filter("span.title")->text());
					$bag->set('released_at', $this->parseDate($node->filter("span.date")->text()));



					$number = floatval(preg_replace("/[c]/", "", basename(dirname($bag->get('url')))));
					$volume = basename(dirname(dirname($bag->get('url'))));

					$volume = preg_match("/^v([0-9]*)$/", $volume) || $volume == 'vTBD'
						? preg_replace("/[v]/", "", $volume)
						: -1;
						

					$bag->set('volume', $volume);
					$bag->set('number', $number);

					return $bag;
				});

				$bag = new Bag();
				$bag->set('chapters', new Collection($chapters));
				$bag->set('volume', $bag->get('chapters')->first()->get('volume'));

				return $bag;
			})))
			;


		return $bag;
	}
}