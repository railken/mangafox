<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class ResourceTest extends TestCase
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

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxResourceRequestNotFoundException
     */
    public function testMangafoxResourceRequestNotFoundException()
    {
        $manga = $this->manager->resource('wrong')->get();
    }

    public function testResourceBasics()
    {
        $manga = $this->manager->resource('fairy_tail')->get();

        $this->assertEquals('fairy_tail', $manga->uid);
        $this->assertEquals('https://fanfox.net/manga/fairy_tail', $manga->url);
        $this->assertEquals('Fairy Tail', $manga->name);
        $this->assertEquals('https://s.fanfox.net/store/manga/246/cover.jpg', $manga->cover);
        $this->assertEquals('MASHIMA Hiro', $manga->author);
        $this->assertEquals('Completed', $manga->status);
    }
}
