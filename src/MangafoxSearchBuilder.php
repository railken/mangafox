<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Bag;
use Railken\Mangafox\Exceptions as Exceptions;

class MangafoxSearchBuilder
{
    /**
     * @var Mangafox
     */
    protected $manager;

    /**
     * The type of manga: "any"|"manga"|"chinese"|"korean".
     *
     * @var string
     */
    protected $type;

    /**
     * Name of resource searched.
     *
     * @var Bag
     */
    protected $name;

    /**
     * Name of artist searched.
     *
     * @var Bag
     */
    protected $artist;

    /**
     * Name of author searched.
     *
     * @var Bag
     */
    protected $author;

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
    protected $genres;

    /**
     * Released year.
     *
     * @var Bag
     */
    protected $released_year;

    /**
     * Rating.
     *
     * @var Bag
     */
    protected $rating;

    /**
     * Completed.
     *
     * @var bool
     */
    protected $completed = null;

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
        $this->name = new Bag();
        $this->artist = new Bag();
        $this->author = new Bag();
        $this->rating = new Bag();
        $this->released_year = new Bag();
        $this->genres = new Bag();
        $this->sort_by = new Bag();
        $this->genres->set('value', new Collection());
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
     * The type of manga: "any"|"manga"|"chinese"|"korean".
     *
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidTypeException::class, $type, ['any', 'manga', 'chinese', 'korean']);

        $this->type = $type;

        return $this;
    }

    /**
     * Return type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the name of resource searched.
     *
     * @param string $filter
     * @param string $name
     *
     * @return $this
     */
    public function name($filter, $name)
    {
        $this->throwExceptionInvalidFilter(Exceptions\MangafoxSearchBuilderInvalidNameFilterException::class, $filter);

        $this->name
            ->set('value', $name)
            ->set('filter', $filter);

        return $this;
    }

    /**
     * Retrieve name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the author of resource searched.
     *
     * @param string $filter
     * @param string $author
     *
     * @return $this
     */
    public function author($filter, $author)
    {
        $this->throwExceptionInvalidFilter(Exceptions\MangafoxSearchBuilderInvalidAuthorFilterException::class, $filter);

        $this->author
            ->set('value', $author)
            ->set('filter', $filter);

        return $this;
    }

    /**
     * Retrieve author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the artist of resource searched.
     *
     * @param string $filter
     * @param string $artist
     *
     * @return $this
     */
    public function artist($filter, $artist)
    {
        $this->throwExceptionInvalidFilter(Exceptions\MangafoxSearchBuilderInvalidArtistFilterException::class, $filter);

        $this->artist
            ->set('value', $artist)
            ->set('filter', $filter);

        return $this;
    }

    /**
     * Retrieve artist.
     *
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set the sort of resource searched.
     *
     * @param string $filter
     * @param string $sort
     *
     * @return $this
     */
    public function sortBy($value, $direction)
    {
        $direction = strtolower($direction);

        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidSortByValueException::class, $value, ['name', 'rating', 'views', 'chapters', 'latest_chapter']);
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidSortByDirectionException::class, $direction, ['asc', 'desc']);

        $this->sort_by
            ->set('field', $value)
            ->set('direction', $direction);

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
     * Set genres.
     *
     * @param string $filter
     * @param array  $genres
     */
    public function genres($filter, $genres)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidGenresFilterException::class, $filter, ['include', 'exclude']);
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidGenresValueException::class, $genres, $this->manager->getGenres());

        $this->genres
            ->set('filter', $filter)
            ->set('value', new Collection($genres));

        return $this;
    }

    /**
     * Retrieve genres.
     *
     * @return Bag
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Set the sort of resource searched.
     *
     * @param string $filter
     * @param string $sort
     *
     * @return $this
     */
    public function releasedYear($filter, $value)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidReleasedYearFilterException::class, $filter, ['<', '=', '>']);

        if (!checkdate(1, 1, (int) $value)) {
            throw new Exceptions\MangafoxSearchBuilderInvalidReleasedYearValueException($value);
        }

        $this->released_year
            ->set('filter', $filter)
            ->set('value', $value);

        return $this;
    }

    /**
     * Retrieve sort.
     *
     * @return string
     */
    public function getReleasedYear()
    {
        return $this->released_year;
    }

    /**
     * Set the sort of resource searched.
     *
     * @param string $filter
     * @param string $sort
     *
     * @return $this
     */
    public function rating($filter, $value)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidRatingFilterException::class, $filter, ['<', '=', '>']);
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidRatingValueException::class, $value, [null, '0', '1', '2', '3', '4', '5']);

        $this->rating
            ->set('filter', $filter)
            ->set('value', $value);

        return $this;
    }

    /**
     * Retrieve sort.
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set the sort of resource searched.
     *
     * @param string $value
     *
     * @return $this
     */
    public function completed($value)
    {
        $this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidCompletedValueException::class, $value, [null, '1', '0']);

        $this->completed = (bool) $value;

        return $this;
    }

    /**
     * Retrieve sort.
     *
     * @return string
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Send request.
     *
     * @return Response
     */
    public function get()
    {
        $request = new MangafoxSearchRequest($this->manager);

        return $request->send($this);
    }

    /**
     * Set common filter for "contains"|"begin"|"end" for name, author and artist.
     *
     * @param string $class
     * @param string $method
     * @param string $value
     */
    private function throwExceptionInvalidFilter($class, $value)
    {
        return $this->throwExceptionInvalidValue($class, $value, ['contains', 'begin', 'end']);
    }
}
