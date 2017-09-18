<?php

namespace Railken\Mangafox;

use \Wa72\HtmlPageDom\HtmlPageCrawler;
use Illuminate\Support\Collection;
use Railken\Mangafox\Exceptions as Exceptions;
use Railken\Bag;

class MangafoxScanParser
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
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Parse the response
     *
     * @return string $html
     *
     * @return MangafoxScanResponse
     */
    public function parse($html)
    {
        $node = HtmlPageCrawler::create($html);

        $bag = new Bag();

        $bag
            ->set('scan', $node->filter('.read_img > a > img')->attr('src'))
            ->set('next', $node->filter('a.next_page')->attr('href'))
            ;


        return $bag;
    }
}
