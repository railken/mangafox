<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Bag;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class MangafoxScanParser
{
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
     * @return string               $html
     * @return MangafoxScanResponse
     */
    public function parse($html)
    {
        $node = HtmlPageCrawler::create($html);

        return new Collection($node->filter('#viewer img')->each(function ($node) {
            $bag = new Bag();
	    
            $bag->set('scan', "https:" . $node->attr('data-original'));

            return $bag;
        }));
    }
}
