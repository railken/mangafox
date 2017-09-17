<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;
use DateTime;
use Railken\Mangafox\Exceptions\MangafoxResourceParserDateNotSupported;

class MangafoxReleasesParser
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

		$bag->set('pages', $node->filter("div#nav > ul > li:nth-child(11)")->text());
		$bag->set('results', new Collection($node->filter("ul#updates > li")->each(function ($node) {
			$bag = new Bag();

			$bag->set('url', $node->filter('.title a')->attr('href'));
			$bag->set('name', $node->filter('.title a')->text());
			$bag->set('uid', basename($bag->get('url')));
			$bag->set('chapters', $node->filter('dt')->each(function ($node) {
				$bag = new Bag();

				$number = floatval(preg_replace("/[c]/", "", basename(dirname($bag->get('url')))));
				$volume = basename(dirname(dirname($bag->get('url'))));

				$bag->set('released_at', $this->parseDate($node->filter('em')->text()));
				$bag->set('url', $node->filter('a')->attr('href'));
				return $bag;
			}));

			return $bag;
		})));
		
		$bag->set('page', $node->filter("li.red")->text());

		return $bag;
	}

	/**
	 * Parse data from text (e.g 10 minutes ago) to formatted "Y-m-d H:i:s"
	 *
	 * @param string $date
	 *
	 * @return string
	*/
	public function parseDate($date)
	{

		$now = new DateTime();

		if (preg_match("/^([0-9]*) ([\w]*) ago$/", $date, $res)) {

			$types = [
				'minutes','minute','seconds','second','hours','hour','days','day'
			];

			if (in_array($res[2], $types)) {

				return $now->modify("-".$res[1]." ".$res[2])->format('Y-m-d H:i:s');

			} else {
				throw new Exceptions\MangafoxResourceParserDateNotSupportedExceptoin($res[2]);
			}
	
		}

		$today = $now->setTime(00, 00, 00);

		if ($date == 'Today')
			return $today->format('Y-m-d H:i:s');

		if ($date == 'Yesterday')
			return $today->modify('-1 days')->format('Y-m-d H:i:s');

		
		return DateTime::createFromFormat('M d, Y', $date)->setTime(00,00,00)->format('Y-m-d H:i:s');

		
	}
}