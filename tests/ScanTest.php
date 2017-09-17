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

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxScanBuilderInvalidUrlException
     */
    public function testMangafoxScanBuilderInvalidUrlException()
    {
        $manga = $this->manager->scanByUrl("wrong")->get();
    }

    public function testBasics()
    {

        $manga = $this->manager->resource('one_piece')->get();

        $chapter = $manga->volumes->first()->chapters->first();

        $scans = $this->manager->scanByUrl($chapter->url)->get();
        $scans = $this->manager->scan($manga->uid, $chapter->volume, $chapter->number)->get();


    }
}