<?php

namespace Railken\Mangafox;

class MangafoxReleasesBuilder
{
    /**
     * @var Mangafox
     */
    protected $manager;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * Construct.
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }

    /**
     * The page.
     *
     * @param string $page
     *
     * @return $this
     */
    public function page($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Return page.
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Send request.
     *
     * @return Response
     */
    public function get()
    {
        $request = new MangafoxReleasesRequest($this->manager);

        return $request->send($this);
    }
}
