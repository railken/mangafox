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
        	->type('any') # any|manga|chinese|korean
        	->name('contains', 'One piece')
        	->author('contains', '')
        	->artist('contains', '')
        	//->genres(['Action' => -1, 'Drama' => 0, 'Historical' => 1])
        	//->orderBy('name', 'ASC')  # name|rating|views|chapters|latest_chapter : asc|desc
        	->get();

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