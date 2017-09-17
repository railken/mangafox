<?php

namespace Railken\Mangafox;

use Railken\Mangafox\Exceptions as Exceptions;
use Illuminate\Support\Collection;

class MangafoxScanBuilder
{

	/**
	 * @var Mangafox
	 */
	protected $manager;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $manga_uid;

	/**
	 * @var string
	 */
	protected $chapter_number;

	/**
	 * @var string
	 */
	protected $volume_number;

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
	 * Url of first scan
	 *
	 * @param string $url
	 *
	 * @return $this
	 */
	public function url($url)
	{
		
		$url = str_replace($this->manager->getUrl(), "/", $url);

		if (!preg_match("/^\/manga\/([\w]*)\/([\w]*)\/([\w]*)\/([\w]*)\.html$/i", $url)) 
			throw new Exceptions\MangafoxScanBuilderInvalidUrlException($url, "/manga/one_piece/v01/c001/1.html");
		
		$this->url = $url;

		return $this;
	}

	/**
	 * Return url
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * manga_uid
	 *
	 * @param string $manga_uid
	 *
	 * @return $this
	 */
	public function mangaUid($manga_uid)
	{
	
		$this->manga_uid = $manga_uid;

		return $this;
	}

	/**
	 * Return manga_uid
	 *
	 * @return string
	 */
	public function getMangaUid()
	{
		return $this->manga_uid;
	}

	/**
	 * volume_number
	 *
	 * @param string $volume_number
	 *
	 * @return $this
	 */
	public function volumeNumber($volume_number)
	{
	
		$this->volume_number = $volume_number;

		return $this;
	}

	/**
	 * Return volume_number
	 *
	 * @return string
	 */
	public function getVolumeNumber()
	{
		return $this->volume_number;
	}


	/**
	 * chapter_number
	 *
	 * @param string $chapter_number
	 *
	 * @return $this
	 */
	public function chapterNumber($chapter_number)
	{
	
		$this->chapter_number = $chapter_number;

		return $this;
	}

	/**
	 * Return chapter_number
	 *
	 * @return string
	 */
	public function getChapterNumber()
	{
		return $this->chapter_number;
	}

	/**
	 * Send request
	 *
	 * @return Response
	 */
	public function get()
	{

		$request = new MangafoxScanRequest($this->manager);

		return $request->send($this);
	}
}