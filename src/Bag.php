<?php

namespace Railken\Mangafox;

class Bag
{

	/**
	 * All values saved in this bag
	 *
	 * @var Array
	 */
	protected $values;

	/**
	 * Set a value
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function set($name, $value)
	{
		$this->values[$name] = $value;

		return $this;
	}

	/**
	 * Retrieve a value
	 *
	 * @param string $name
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get($name, $default = null)
	{
		return isset($this->values[$name]) ? $this->values[$name] : $default;
	}

	/**
	 * @call
	 *
	 * @param string $name
	 */
	public function __get($attribute)
	{

		if ($value = $this->get($attribute))
			return $value;

	}
}