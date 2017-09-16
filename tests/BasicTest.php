<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class BasicTest extends TestCase
{
   
    public function testA()
    {
       
        $m = new Mangafox();

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