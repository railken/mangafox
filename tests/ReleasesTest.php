<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class ReleasesTest extends TestCase
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

    public function testReleasesBase()
    {
        $results = $this->manager->releases()->page(1)->get();
    }
}
