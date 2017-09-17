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

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxResourceRequestNotFoundException
     */
    public function testMangafoxResourceRequestNotFoundException()
    {
        $manga = $this->manager->resource('wrong')->get();
    }

    public function testBasics()
    {
      
        $manga = $this->manager->resource('one_piece')->get();

        $this->assertEquals('one_piece', $manga->uid);


    }
}