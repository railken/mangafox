<?php

namespace Railken\Mangafox;

class MangafoxSearchRequest
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
     * Convert the raw for request.
     *
     * @param string $filter
     *
     * @return string
     */
    public function getRawCommonFilter($filter)
    {
        switch ($filter) {
            case 'begin':
                return 'bw';
            break;

            case 'contains':
                return 'cw';
            break;

            case 'end':
                return 'ew';
            break;
        }
    }

    /**
     * Convert the raw for request.
     *
     * @param string $filter
     *
     * @return string
     */
    public function getRawCommonFilter2($filter)
    {
        switch ($filter) {
            case '=':
                return 'eq';
            break;

            case '<':
                return 'lt';
            break;

            case '>':
                return 'gt';
            break;
        }
    }

    /**
     * Send the request for the research.
     *
     * @param MangafoxSearchBuilder $builder
     *
     * @return MangafoxSearchResponse
     */
    public function send(MangafoxSearchBuilder $builder)
    {
        $params = [];

        $params['advopts'] = 1;

        // Name
        $params['name_method'] = $this->getRawCommonFilter($builder->getName()->get('filter'));
        $params['name'] = str_replace('%20', ' ', $builder->getName()->get('value'));

        // Type
        $params['type'] = $builder->getType();

        // Author
        $params['author_method'] = $this->getRawCommonFilter($builder->getAuthor()->get('filter'));
        $params['author'] = $builder->getAuthor()->get('value');

        // Artist
        $params['artist_method'] = $this->getRawCommonFilter($builder->getArtist()->get('filter'));
        $params['artist'] = $builder->getArtist()->get('value');

        // Sort
        $params['sort'] = $builder->getSortBy()->get('field');
        $params['order'] = $builder->getSortBy()->get('direction') == 'desc' ? 'za' : 'az';

        // Genres
        $params['genres'] = $builder->getGenres()->get('value')->mapWithKeys(function ($item) use ($builder) {
            return [$item => $builder->getGenres()->get('filter') == 'include' ? 1 : 2];
        })->toArray();

        // Released
        $params['released_method'] = $this->getRawCommonFilter2($builder->getReleasedYear()->get('filter'));
        $params['released'] = $builder->getReleasedYear()->get('value');

        // Rating
        $params['rating_method'] = $this->getRawCommonFilter2($builder->getRating()->get('filter'));
        $params['rating'] = $builder->getRating()->get('value');

        // Is completed?
        if ($builder->getCompleted() !== null) {
            $params['is_completed'] = $builder->getCompleted() === true ? '1' : '0';
        }

        $params['page'] = $builder->getPage();

        $results = $this->manager->request('GET', '/search', $params);

        $parser = new MangafoxSearchParser($this->manager);

        return $parser->parse($results);
    }
}
