<?php

namespace Railken\Mangafox;

class Mangafox extends MangaReader
{
    /**
     * Base url mangafox.
     *
     * @var string
     */
    protected $urls = [
        'app'    => 'https://fanfox.net',
        'mobile' => 'https://m.fanfox.net',
    ];

    /**
     * List of genres available on mangafox.
     *
     * @var string[]
     */
    protected $genres = [
        'Action',
        'Adult',
        'Adventure',
        'Comedy',
        'Doujinshi',
        'Drama',
        'Ecchi',
        'Fantasy',
        'Gender Bender',
        'Harem',
        'Historical',
        'Horror',
        'Josei',
        'Martial Arts',
        'Mature',
        'Mecha',
        'Mystery',
        'One Shot',
        'Psychological',
        'Romance',
        'School Life',
        'Sci-fi',
        'Seinen',
        'Shoujo',
        'Shoujo Ai',
        'Shounen',
        'Shounen Ai',
        'Slice of Life',
        'Smut',
        'Sports',
        'Supernatural',
        'Tragedy',
        'Webtoons',
        'Yaoi',
        'Yuri',
    ];

    /**
     * Retrieve base url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retrieve base url.
     *
     * @param string $path
     *
     * @return string
     */
    public function getAppUrl($path)
    {
        return $this->urls['app'].$path;
    }

    /**
     * Perform a search.
     *
     * @return MangafoxSearchBuilder
     */
    public function search()
    {
        return new MangafoxSearchBuilder($this);
    }

    /**
     * Request a specific resource.
     *
     * @param string $uid
     *
     * @return MangafoxResourceBuilder
     */
    public function resource($uid = null)
    {
        return (new MangafoxResourceBuilder($this))->uid($uid);
    }

    /**
     * Request all scans for a chapter.
     *
     * @param string $manga_uid
     * @param string $volume_number
     * @param string $chapter_number
     *
     * @return MangafoxScanBuilder
     */
    public function scan($manga_uid, $volume_number, $chapter_number)
    {
        return (new MangafoxScanBuilder($this))->mangaUid($manga_uid)->volumeNumber($volume_number)->chapterNumber($chapter_number);
    }

    /**
     * Perform a search in last releases.
     *
     * @return MangafoxReleasesBuilder
     */
    public function releases()
    {
        return new MangafoxReleasesBuilder($this);
    }

    /**
     * Perform a search in directory.
     *
     * @return MangafoxDirectoryBuilder
     */
    public function directory()
    {
        return new MangafoxDirectoryBuilder($this);
    }

    /**
     * Retrieve a list of all resources.
     *
     * @return MangafoxIndexBuilder
     */
    public function index()
    {
        return new MangafoxIndexBuilder($this);
    }

    /**
     * Retrieve genres available on mangafox.
     *
     * @return array
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
