<?php

namespace Railken\Mangafox;

class MangafoxIndexRequest
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
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * Send the request.
     *
     * @param MangafoxIndexBuilder $builder
     *
     * @return MangafoxIndexResponse
     */
    public function send(MangafoxIndexBuilder $builder)
    {
        $results = $this->manager->request('GET', '/manga/', []);

        $parser = new MangafoxIndexParser($this->manager);

        return $parser->parse($results);
    }
}
