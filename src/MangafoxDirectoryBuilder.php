<?php

namespace Railken\Mangafox;

use Railken\Bag;
use Railken\Mangafox\Exceptions as Exceptions;

class MangafoxDirectoryBuilder
{
    /**
     * @var Mangafox
     */
    protected $manager;

    /**
     * Page.
     *
     * @var string
     */
    protected $page = 1;

    /**
     * Sort By.
     *
     * @var Bag
     */
    protected $sort_by;

    /**
     * Genres.
     *
     * @var Bag
     */
    protected $browse_by;

    /**
     * Construct.
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
        $this->browse_by = new Bag();
        $this->sort_by = new Bag();
    }

    /**
     * Throw an exceptions if value doesn't match with suggestion.
     *
     * @param string $class
     * @param mixed  $value
     * @param array  $suggestions
     */
    public function throwExceptionInvalidValue($class, $value, $suggestions)
    {
        if (is_array($value)) {
            if (count(array_diff($value, $suggestions)) != 0) {
                throw new $class($value, $suggestions);
            }
        } else {
            if (!in_array($value, $suggestions)) {
                throw new $class($value, $suggestions);
            }
        }
    }

    /**
     * Sorts.
     *
     * @param string $value
     *
     * @return $this
     */
    public function sortBy($value)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxDirectoryBuilderInvalidSortByValueException::class, $value, ['name', 'popularity', 'rating', 'latest_chapter']);

        $this->sort_by
            ->set('field', $value);

        return $this;
    }

    /**
     * Retrieve sort.
     *
     * @return string
     */
    public function getSortBy()
    {
        return $this->sort_by;
    }

    /**
     * Browse by.
     *
     * @param string $filter
     * @param string $value
     *
     * @return $this
     */
    public function browseBy($filter, $value)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxDirectoryBuilderInvalidBrowseByFilterException::class, $filter, ['genre', 'initial', 'released_year', 'status']);

        switch ($filter) {
            case 'genre':
                $this->throwExceptionInvalidValue(Exceptions\MangafoxDirectoryBuilderInvalidBrowseByGenreValueException::class, $value, array_merge(['All'], $this->manager->getGenres()));
            break;

            case 'initial':
                $this->throwExceptionInvalidValue(Exceptions\MangafoxDirectoryBuilderInvalidBrowseByInitialValueException::class, $value, array_merge(['#'], range('A', 'Z')));
            break;

            case 'released_year':

                if ($value != 'older' && !checkdate(1, 1, (int) $value)) {
                    throw new Exceptions\MangafoxDirectoryBuilderInvalidBrowseByReleasedYearValueException($value);
                }

            break;

            case 'status':
                $this->throwExceptionInvalidValue(Exceptions\MangafoxDirectoryBuilderInvalidBrowseByStatusValueException::class, $value, ['New', 'Updated', 'Completed', 'Ongoing']);
            break;
        }

        $this->browse_by
            ->set('filter', $filter)
            ->set('value', $value);

        return $this;
    }

    /**
     * Retrieve sort.
     *
     * @return string
     */
    public function getBrowseBy()
    {
        return $this->browse_by;
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
        $request = new MangafoxDirectoryRequest($this->manager);

        return $request->send($this);
    }
}
