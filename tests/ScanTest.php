<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class ScanTest extends TestCase
{
    /**
     * @var Railken\Mangafox\Mangafox
     */
    private $manager;

    /**
     * Called on setup.
     */
    public function setUp()
    {
        $this->manager = new Mangafox();
    }

    public function testScanBasics()
    {
        $manga = $this->manager->resource('fairy_tail')->get();

        $chapter = $manga->chapters[0];

        $this->manager->scan($manga->uid, $chapter->volume, $chapter->number)->get()->each(function ($scan) {
            $this->assertTrue(filter_var($scan->scan, FILTER_VALIDATE_URL) !== false);
        });
    }
}
