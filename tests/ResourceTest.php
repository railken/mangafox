<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

class ResourceTest extends TestCase
{

    /**
     * @var Railken\Mangafox\Mangafox
     */
    private $manager;

    /**
     * Called on setup
     *
     * @return void
     */
    public function setUp()
    {
        $this->manager = new Mangafox();
    }

    public function testBasics()
    {
      
        $manga = $this->manager->resource('one_piece')->get();

        print_r($manga);

        /*
        $results = $m
            ->directory()
            ->browseBy('genre', 'Action')  # genre|initial_alphabetic|released_year|status
            ->orderBy('name', 'ASC') # name|popularity|rating|latest_chapter
            ->page(1)
            ->get();

        $results = $m
            ->latestReleases()
            ->page(1)
            ->get();
        */



        /*

        $manga = $results->first();

        # Retrieve

        $manga = $m->find($manga->getId());
        $chapter = $maga->getChapters()->first();


        $scans = $m->scan($manga, $chapter);
        */

    }
}