<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class SearchTest extends TestCase
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
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidTypeException
     */
    public function testMangafoxSearchBuilderInvalidTypeException()
    {
        $this->manager->search()->type('wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidNameFilterException
     */
    public function testMangafoxSearchBuilderInvalidNameFilterException()
    {
        $this->manager->search()->name('wrong', 'One Piece');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidAuthorFilterException
     */
    public function testMangafoxSearchBuilderInvalidAuthorFilterException2()
    {
        $this->manager->search()->author('wrong', 'Oda Eiichiro');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidArtistFilterException
     */
    public function testMangafoxSearchBuilderInvalidArtistFilterException3()
    {
        $this->manager->search()->artist('wrong', 'Oda Eiichiro');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidGenresFilterException
     */
    public function testMangafoxSearchBuilderInvalidGenresFilterException()
    {
        $this->manager->search()->genres('wrong', ['Action']);
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidGenresValueException
     */
    public function testMangafoxSearchBuilderInvalidGenresValueException()
    {
        $this->manager->search()->genres('include', ['Food']);
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidSortByDirectionException
     */
    public function testMangafoxSearchBuilderInvalidSortByDirectionException()
    {
        $this->manager->search()->sortBy('name', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidSortByValueException
     */
    public function testMangafoxSearchBuilderInvalidSortByValueException()
    {
        $this->manager->search()->sortBy('wrong', 'asc');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidReleasedYearFilterException
     */
    public function testMangafoxSearchBuilderInvalidReleasedYearFilterException()
    {
        $this->manager->search()->releasedYear('wrong', '2017');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidReleasedYearValueException
     */
    public function testMangafoxSearchBuilderInvalidReleasedYearValueException()
    {
        $this->manager->search()->releasedYear('<', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidRatingFilterException
     */
    public function testMangafoxSearchBuilderInvalidRatingFilterException()
    {
        $this->manager->search()->rating('wrong', '5');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidRatingValueException
     */
    public function testMangafoxSearchBuilderInvalidRatingValueException()
    {
        $this->manager->search()->rating('<', 'wrong');
    }

    /**
     * @expectedException \Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidCompletedValueException
     */
    public function testMangafoxSearchBuilderInvalidCompletedValueException()
    {
        $this->manager->search()->completed('wrong');
    }

    public function testSearchBase()
    {
        $m = $this->manager;

        // Search manga
        $result = $m
            ->search()
            ->type('any')
            ->name('contains', 'One Piece')
            ->author('contains', 'Oda Eiichiro')
            ->artist('contains', 'Oda Eiichiro')
            ->genres('include', ['Action', 'Drama', 'Historical'])
            ->releasedYear('<', '2017')
            ->rating('>', 4)
            ->completed(0)
            ->page(1)
            ->sortBy('name', 'ASC')
            ->get();

        $results = $result->results;

        $manga = $results->filter(function ($v) {
            return $v->uid == 'one_piece';
        })->first();

        $this->assertEquals('One Piece', $manga->name);

        // Send an empty request
        $results = $m
            ->search()
            ->get();
    }
}
