<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;
use Illuminate\Support\Collection;

class MangafoxSearchBuilder
{

	/**
	 * @var Mangafox
	 */
	protected $manager;

	/**
	 * The type of manga: "any"|"manga"|"chinese"|"korean"
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Name of resource searched
	 *
	 * @var Bag
	 */
	protected $name;

	/**
	 * Name of artist searched
	 *
	 * @var Bag
	 */
	protected $artist;

	/**
	 * Name of author searched
	 *
	 * @var Bag
	 */
	protected $author;

	/**
	 * Sort By
	 *
	 * @var Bag
	 */
	protected $sort_by;

	/**
	 * Genres
	 *
	 * @var Bag
	 */
	protected $genres;

	/**
	 * Released year
	 *
	 * @var Bag
	 */
	protected $released_year;

	/**
	 * Rating
	 *
	 * @var Bag
	 */
	protected $rating;

	/**
	 * Completed
	 *
	 * @var boolean
	 */
	protected $completed = null;

	/**
	 * Construct
	 *
	 * @param Mangafox $manager
	 */
	public function __construct($manager)
	{
		$this->manager = $manager;
	}

	/** 
	  * Set common filter for "contains"|"begin"|"end" for name, author and artist
	  *
	  * @param string $attribute
	  * @param string $value
	  *
	  * @return void
	  */
	private function commonFilter($attribute, $value)
	{

		$suggestions = ['contains', 'begin', 'end'];

		if (!in_array($value, $suggestions))
			throw new Exceptions\MangafoxSearchBuilderInvalidFilterException($attribute, $value, $suggestions);

		$attribute .= "_filter";

		$this->{$attribute} = $value;
	}

	/**
	 * The type of manga: "any"|"manga"|"chinese"|"korean"
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
	 * Return type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set the name of resource searched
	 *
	 * @param string $filter
	 * @param string $name
	 *
	 * @return $this
	 */
	public function name($filter, $name)
	{
		$this->commonFilter("name", $filter);

		$this->name = (new Bag())
					->set('value', $name)
					->set('filter', $filter);
		
		return $this;
	}


	/**
	 * Retrieve name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the author of resource searched
	 *
	 * @param string $filter
	 * @param string $author
	 *
	 * @return $this
	 */
	public function author($filter, $author)
	{
		$this->commonFilter("author", $filter);
		
		$this->author = (new Bag())
					->set('value', $author)
					->set('filter', $filter);
		
		return $this;
	}

	/**
	 * Retrieve author
	 *
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}


	/**
	 * Set the artist of resource searched
	 *
	 * @param string $filter
	 * @param string $artist
	 *
	 * @return $this
	 */
	public function artist($filter, $artist)
	{
		$this->commonFilter("artist", $filter);
		
		$this->artist = (new Bag())
					->set('value', $artist)
					->set('filter', $filter);
		
		return $this;
	}

	/**
	 * Retrieve artist
	 *
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}



	/**
	 * Set the sort of resource searched
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
		
		$this->sort_by = (new Bag())
					->set('field', $value)
					->set('direction', $direction);
		
		return $this;
	}

	/**
	 * Retrieve sort
	 *
	 * @return string
	 */
	public function getSortBy()
	{
		return $this->sort_by;
	}

	/**
	 * Set genres
	 *
	 * @param string $filter
	 * @param array $genres
	 */
	public function genres($filter, $genres)
	{

		$this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidGenresFilterException::class, $filter, ['include', 'exclude']);
		$this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidGenresValueException::class, $genres, $this->manager->getGenres());

		$this->genres = (new Bag())
					->set('filter', $filter)
					->set('value', new Collection($genres));

		return $this;
	}

	/**
	 * Retrieve genres
	 *
	 * @return Bag
	 */
	public function getGenres()
	{
		return $this->genres;
	}

	/**
	 * Throw an exceptions if value doesn't match with suggestion
	 *
	 * @param string $class 
	 * @param mixed $value
	 * @param array $suggestions
	 *
	 * @return void
	 */
	public function throwExceptionInvalidValue($class, $value, $suggestions)
	{
		if (is_array($value)) {

			if (count(array_diff($value, $suggestions)) != 0)
				throw new $class($value, $suggestions);
		} else {

			if (!in_array($value, $suggestions))
				throw new $class($value, $suggestions);
		}

	}

	/**
	 * Set the sort of resource searched
	 *
	 * @param string $filter
	 * @param string $sort
	 *
	 * @return $this
	 */
	public function releasedYear($filter, $value)
	{

		$this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidReleasedYearFilterException::class, $filter, ['<', '=', '>']);

		if (!checkdate(1, 1, (int)$value)) {
			throw new Exceptions\MangafoxSearchBuilderInvalidReleasedYearValueException($value);
		}

		$this->released_year = (new Bag())
					->set('filter', $filter)
					->set('value', $value);
		
		return $this;
	}

	/**
	 * Retrieve sort
	 *
	 * @return string
	 */
	public function getReleasedYear()
	{
		return $this->released_year;
	}


	/**
	 * Set the sort of resource searched
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

		$this->rating = (new Bag())
					->set('filter', $filter)
					->set('value', $value);
		
		return $this;
	}

	/**
	 * Retrieve sort
	 *
	 * @return string
	 */
	public function getRating()
	{
		return $this->rating;
	}

	/**
	 * Set the sort of resource searched
	 *
	 * @param string $value
	 *
	 * @return $this
	 */
	public function completed($value)
	{

		$this->throwExceptionInvalidValue(Exceptions\MangafoxSearchBuilderInvalidCompletedValueException::class, $value, [null, '1', '0']);

		$this->completed = (boolean)$value;
		
		return $this;
	}

	/**
	 * Retrieve sort
	 *
	 * @return string
	 */
	public function getCompleted()
	{
		return $this->completed;
	}

	/**
	 * Send request
	 *
	 * @return Response
	 */
	public function get()
	{

		$request = new MangafoxSearchRequest($this->manager);

		return $request->send($this);
	}
}