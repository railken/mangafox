<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

class ScanTest extends TestCase
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

        $manga = $this->manager->resource('fairy_tail')->get();


        $chapter = $manga->volumes->first()->chapters[0];

        $this->manager->scan($manga->uid, $chapter->volume, $chapter->number)->get()->each(function($scan) {
            file_get_contents($scan->scan);
        });



    }
}