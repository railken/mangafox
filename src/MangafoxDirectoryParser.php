<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Bag;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class MangafoxDirectoryParser extends MangafoxSearchParser
{
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
        $bag->set('results', new Collection($node->filter('.manga-list-1-list > li')->each(function ($node) {
            $bag = new Bag();

            $title = $node->filter('.manga-list-1-item-title > a');

            return $bag
                ->set('uid', basename($title->attr('href')))
                ->set('name', $title->html())
                ->set('url', $this->manager->getAppUrl($title->attr('href')))
                ->set('cover', $node->filter('img')->attr('src'))
                ->set('latest', $this->manager->getAppUrl($node->filter('.manga-list-1-item-subtitle > a')->attr('href')))
                ->set('rating', $node->filter('.item-score')->text())
                ;
        })));

        $bag->set('page', $node->filter('.pager-list-left .active')->text());

        return $bag;
    }
}
