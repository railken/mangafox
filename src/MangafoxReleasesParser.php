<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;
use Railken\Mangafox\Traits\ParseDateTrait;
use Railken\Bag;

class MangafoxReleasesParser
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
    public function __construct(Mangafox $manager)
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

            $bag->set('url', "http:".$node->filter('.title a')->attr('href'));
            $bag->set('name', $node->filter('.title a')->text());
            $bag->set('uid', basename($bag->get('url')));
            $bag->set('chapters', $node->filter('dt')->each(function ($node) {
                $bag = new Bag();

                $number = floatval(preg_replace("/[c]/", "", basename(dirname($bag->get('url')))));
                $volume = basename(dirname(dirname($bag->get('url'))));

                $bag->set('released_at', $this->parseDate($node->filter('em')->text()));
                $bag->set('url', "http:".$node->filter('a')->attr('href'));
                return $bag;
            }));

            return $bag;
        })));

        $bag->set('page', $node->filter("li.red")->text());

        return $bag;
    }
}
