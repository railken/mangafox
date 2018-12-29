<?php

namespace Railken\Mangafox;

class MangafoxScanRequest
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
     * Send the request for scans.
     *
     * @param MangafoxScanBuilder $builder
     *
     * @return MangafoxScanResponse
     */
    public function send(MangafoxScanBuilder $builder)
    {
        $volume = $builder->getVolumeNumber() !== '-1' ? "/v{$builder->getVolumeNumber()}" : '';

        $chapter = '/c'.str_pad($builder->getChapterNumber(), 3, '0', STR_PAD_LEFT);

        $url = "/roll_manga/{$builder->getMangaUid()}{$volume}{$chapter}";

        $results = $this->manager->requestMobile('GET', $url, []);

        $parser = new MangafoxScanParser($this->manager);

        return $parser->parse($results);
    }
}
