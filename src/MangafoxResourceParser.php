<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;
use DateTime;
use Railken\Mangafox\Exceptions\MangafoxResourceParserDateNotSupported;

class MangafoxResourceParser
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

		$head = $node->filter("head");
		$title = $node->filter("div#title");
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
			->set('volumes', $node->filter("ul.chlist")->each(function ($node) {


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
			}))
				;


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