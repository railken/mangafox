<?php

namespace Railken\Mangafox;

class MangafoxScanBuilder
{
    /**
     * @var Mangafox
     */
    protected $manager;

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
     * Construct.
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }

    /**
     * manga_uid.
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
     * Return manga_uid.
     *
     * @return string
     */
    public function getMangaUid()
    {
        return $this->manga_uid;
    }

    /**
     * volume_number.
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
     * Return volume_number.
     *
     * @return string
     */
    public function getVolumeNumber()
    {
        return $this->volume_number;
    }

    /**
     * chapter_number.
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
     * Return chapter_number.
     *
     * @return string
     */
    public function getChapterNumber()
    {
        return $this->chapter_number;
    }

    /**
     * Send request.
     *
     * @return Response
     */
    public function get()
    {
        $request = new MangafoxScanRequest($this->manager);

        return $request->send($this);
    }
}
