<?php

use PHPUnit\Framework\TestCase;
use Railken\Mangafox\Mangafox;

class IndexTest extends TestCase
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

    public function testIndexBase()
    {
        $results = $this->manager
            ->index()
            ->get();
    }
}
