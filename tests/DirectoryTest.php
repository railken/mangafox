<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class DirectoryTest extends TestCase
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
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidSortByValueException
     */
    public function testMangafoxDirectoryBuilderInvalidSortByValueException()
    {
        $this->manager->directory()->sortBy('wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidBrowseByFilterException
     */
    public function testMangafoxDirectoryBuilderInvalidBrowseByFilterException()
    {
        $this->manager->directory()->browseBy('wrong', 'Action');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidBrowseByGenreValueException
     */
    public function testMangafoxDirectoryBuilderInvalidBrowseByGenreValueException()
    {
        $this->manager->directory()->browseBy('genre', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidBrowseByStatusValueException
     */
    public function testMangafoxDirectoryBuilderInvalidBrowseByStatusValueException()
    {
        $this->manager->directory()->browseBy('status', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidBrowseByReleasedYearValueException
     */
    public function testMangafoxDirectoryBuilderInvalidBrowseByReleasedYearValueException()
    {
        $this->manager->directory()->browseBy('released_year', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxDirectoryBuilderInvalidBrowseByInitialValueException
     */
    public function testMangafoxDirectoryBuilderInvalidBrowseByInitialValueException()
    {
        $this->manager->directory()->browseBy('initial', 'wrong');
    }

    public function testDirectoryBase()
    {
        $result = $this->manager
            ->directory()
            ->browseBy('genre', 'Action')
            ->sortBy('name')
            ->page(2)
            ->get();

        $this->assertTrue($result->results->count() > 0);
        $this->assertEquals(2, $result->page);
    }
}
