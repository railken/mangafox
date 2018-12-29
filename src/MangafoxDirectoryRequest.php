<?php

namespace Railken\Mangafox;

class MangafoxDirectoryRequest
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
     * Parse sort.
     *
     * @param string $sort
     *
     * @return string
     */
    public function parseSort($sort)
    {
        switch ($sort) {
            case 'name':
                return 'az';
            break;
            case 'latest_chapter':
                return 'latest';
            break;
            case 'popularity':
                return '';
            break;
            case 'rating':
                return 'rating';
            break;
        }
    }

    /**
     * Send the request.
     *
     * @param MangafoxDirectoryBuilder $builder
     *
     * @return MangafoxDirectoryResponse
     */
    public function send(MangafoxDirectoryBuilder $builder)
    {
        $params = [];

        $sort = $this->parseSort($builder->getSortBy()->value);

        if ($sort) {
            $params[$sort] = '';
        }

        $results = $this->manager->request('GET', '/directory/'.strtolower($builder->getBrowseBy()->get('value')).'/'.$builder->getPage().'.htm', $params);

        $parser = new MangafoxDirectoryParser($this->manager);

        return $parser->parse($results);
    }
}
