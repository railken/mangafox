<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

class SearchTest extends TestCase
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
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidTypeException
     */
    public function testMangafoxSearchBuilderInvalidTypeException()
    {
        $this->manager->search()->type('wrong');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidFilterException
     */
    public function testMangafoxSearchBuilderInvalidFilterException()
    {
        $this->manager->search()->name('wrong', 'One Piece');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidFilterException
     */
    public function testMangafoxSearchBuilderInvalidFilterException2()
    {
        $this->manager->search()->author('wrong', 'Oda Eiichiro');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidFilterException
     */
    public function testMangafoxSearchBuilderInvalidFilterException3()
    {
        $this->manager->search()->artist('wrong', 'Oda Eiichiro');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidGenresFilterException
     */
    public function testMangafoxSearchBuilderInvalidGenresFilterException()
    {
        $this->manager->search()->genres('wrong', ['Action']);
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidGenresValueException
     */
    public function testMangafoxSearchBuilderInvalidGenresValueException()
    {
        $this->manager->search()->genres('include', ['Food']);
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidSortByDirectionException
     */
    public function testMangafoxSearchBuilderInvalidSortByDirectionException()
    {
        $this->manager->search()->sortBy('name', 'wrong');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidSortByValueException
     */
    public function testMangafoxSearchBuilderInvalidSortByValueException()
    {
        $this->manager->search()->sortBy('wrong', 'asc');
    }


    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidReleasedYearFilterException
     */
    public function testMangafoxSearchBuilderInvalidReleasedYearFilterException()
    {
        $this->manager->search()->releasedYear('wrong', '2017');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidReleasedYearValueException
     */
    public function testMangafoxSearchBuilderInvalidReleasedYearValueException()
    {
        $this->manager->search()->releasedYear('<', 'wrong');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidRatingFilterException
     */
    public function testMangafoxSearchBuilderInvalidRatingFilterException()
    {
        $this->manager->search()->rating('wrong', '5');
    }

    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidRatingValueException
     */
    public function testMangafoxSearchBuilderInvalidRatingValueException()
    {
        $this->manager->search()->rating('<', 'wrong');
    }


    /**
     * @expectedException Railken\Mangafox\Exceptions\MangafoxSearchBuilderInvalidCompletedValueException
     */
    public function testMangafoxSearchBuilderInvalidCompletedValueException()
    {
        $this->manager->search()->completed('wrong');
    }

    public function testBasics()
    {
       

        $m = $this->manager;


        # Search manga
        $results = $m
            ->search()
            ->type('any')
            ->name('contains', 'One Piece')
            ->author('contains', 'Oda Eiichiro')
            ->artist('contains', 'Oda Eiichiro')
            ->genres('include', ['Action', 'Drama', 'Historical'])
            ->releasedYear('<', '2017')
            ->rating('>', 4)
            ->completed(0)
            ->sortBy('name', 'ASC')
            ->get();

        $manga = $results->filter(function($v) {
            return $v->uid == 'one_piece';
        })->first();

        $this->assertEquals(106, $manga->id);


        // Send an empty request
        $results = $m
            ->search()
            ->get();



        $search = $m->search();

        $search->type('any');

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


        $manga = $results->first();

        # Retrieve

        $manga = $m->find($manga->getId());
        $chapter = $maga->getChapters()->first();


        $scans = $m->scan($manga, $chapter);
        */
    }
}