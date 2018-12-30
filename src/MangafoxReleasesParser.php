<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Bag;
use Railken\Mangafox\Traits\ParseDateTrait;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class MangafoxReleasesParser
{
    use ParseDateTrait;

    /*
     * @var Mangafox
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Parse the response.
     *
     * @return string                 $html
     * @return MangafoxSearchResponse
     */
    public function parse($html)
    {
        $node = HtmlPageCrawler::create($html);

        $bag = new Bag();

        $bag->set('pages', $node->filter('.pager-list-left a:nth-last-child(2)')->text());
        $bag->set('results', new Collection($node->filter('.manga-list-4-list > li')->each(function ($node) {
            $bag = new Bag();

            $title = $node->filter('.manga-list-4-item-title > a');

            $bag
                ->set('uid', basename($title->attr('href')))
                ->set('name', $title->html())
                ->set('url', $this->manager->getAppUrl($title->attr('href')))
                ->set('cover', $node->filter('img')->attr('src'))
                ->set('updated_at', $this->parseDate($node->filter('.manga-list-4-item-subtitle > span')->text()))
            ;

            $bag->set('chapters', Collection::make($node->filter('ul.manga-list-4-item-part > li')->each(function ($node) {
                $bag = new Bag();

                $bag->set('url', $this->manager->getAppUrl($node->filter('a')->attr('href')));

                return $bag;
            }))->filter(function ($bag) {
                $ext = pathinfo(basename($bag->get('url')), PATHINFO_EXTENSION);

                return !empty($ext);
            }));

            return $bag;
        })));

        $bag->set('page', $node->filter('.pager-list-left .active')->text());

        return $bag;
    }
}
