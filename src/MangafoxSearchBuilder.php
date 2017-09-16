<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;

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
		if (!in_array($value, ['contains', 'begin', 'end']))
			throw new Exceptions\MangafoxSearchBuilderInvalidFilterException($attribute);

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

		if (!in_array($type, ['any', 'manga', 'chinese', 'korean']))
			throw new Exceptions\MangafoxSearchBuilderInvalidTypeException();

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