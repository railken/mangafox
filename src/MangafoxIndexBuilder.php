<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;
use Illuminate\Support\Collection;
use Railken\Bag;

class MangafoxIndexBuilder
{

    /**
     * @var Mangafox
     */
    protected $manager;

    /**
     * Construct
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Send request
     *
     * @return Response
     */
    public function get()
    {
        $request = new MangafoxIndexRequest($this->manager);

        return $request->send($this);
    }
}
