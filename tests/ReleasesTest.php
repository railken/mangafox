<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

class LatestUpdateTest extends TestCase
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

        $results = $this->manager->releases()->page(1)->get();


        /*
        $results = $m
            ->directory()
            ->browseBy('genre', 'Action')  # genre|initial_alphabetic|released_year|status
            ->orderBy('name', 'ASC') # name|popularity|rating|latest_chapter
            ->page(1)
            ->get();
        */

    }
}