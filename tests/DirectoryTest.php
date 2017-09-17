<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

class DirectoryTest extends TestCase
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


    public function testBasics()
    {
        $results = $this->manager
            ->directory()
            ->browseBy('genre', 'Action')
            ->sortBy('name') 
            ->page(1)
            ->get();


    }
}