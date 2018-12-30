<?php

namespace Railken\Mangafox;

class MangafoxIndexParser extends MangafoxDirectoryParser
{
    /*
     * @var Mangafox
     */
    protected $manager;

    /**
     * Constructor.
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }
}
