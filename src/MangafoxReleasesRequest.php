<?php

namespace Railken\Mangafox;

class MangafoxReleasesRequest
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

    /**
     * Send the request for the reReleases.
     *
     * @param MangafoxReleasesBuilder $builder
     *
     * @return MangafoxReleasesResponse
     */
    public function send(MangafoxReleasesBuilder $builder)
    {
        $results = $this->manager->request('GET', "/releases/{$builder->getPage()}.htm", []);

        $parser = new MangafoxReleasesParser($this->manager);

        return $parser->parse($results);
    }
}
