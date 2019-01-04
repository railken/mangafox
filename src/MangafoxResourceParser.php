<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Bag;
use Railken\Mangafox\Traits\ParseDateTrait;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class MangafoxResourceParser
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

        $head = $node->filter('head');
        $title = $node->filter('div#title');

        if (strpos($head->filter("[name='og:url']")->attr('content'), 'http://mangafox.me/manga/') === false) {
            throw new Exceptions\MangafoxResourceParserInvalidUrlException();
        }

        $bag = new Bag();
        $bag
            ->set('url', $this->manager->getAppUrl('/manga/'.basename($head->filter("[name='og:url']")->attr('content'))))
            ->set('uid', basename($bag->get('url')))
            ->set('name', $node->filter('.detail-info-cover-img')->attr('alt'))
            ->set('cover', $node->filter('.detail-info-cover-img')->attr('src'))
            ->set('description', $node->filter('.fullcontent')->text())
            ->set('author', $node->filter('.detail-info-right-say > a')->text())
            ->set('genres', explode(' ', trim($node->filter('.detail-info-right-tag-list')->text())))
            ->set('status', $node->filter('.detail-info-right-title .detail-info-right-title-tip')->text())
            ->set('rating', $node->filter('.detail-info-right-title .detail-info-right-title-star .item-score')->text())
            ->set('chapters', new Collection($node->filter('#chapterlist > #list-2 > ul > li')->each(function ($node) {
                $bag = new Bag();

                $chapterTitles = explode('-', $node->filter('.title3')->text());

                $bag->set('url', $this->manager->getAppUrl($node->filter('a')->attr('href')));
                $bag->set('title', trim(array_pop($chapterTitles)));
                $bag->set('released_at', $this->parseDate(trim($node->filter('.title2')->text())));

                $number = floatval(preg_replace('/[c]/', '', basename(dirname($bag->get('url')))));
                $volume = basename(dirname(dirname($bag->get('url'))));

                $volume = preg_match('/^v([0-9]*)$/', $volume) || $volume == 'vTBD'
                    ? preg_replace('/[v]/', '', $volume)
                    : -1;

                $bag->set('volume', $volume);
                $bag->set('number', $number);

                return $bag;
            })))
            ;

        return $bag;
    }
}
