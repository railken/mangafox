<?php

namespace Railken\Mangafox;

use Illuminate\Support\Collection;
use Railken\Mangafox\Exceptions as Exceptions;

class MangafoxScanRequest
{
    
    /*
     * @var Mangafox
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param Mangafox $manager
     */
    public function __construct(Mangafox $manager)
    {
        $this->manager = $manager;
    }


    /**
     * Send the request for scans
     *
     * @param MangafoxScanBuilder $builder
     *
     * @return MangafoxScanResponse
     */
    public function send(MangafoxScanBuilder $builder)
    {
        
        $url = "/roll_manga/{$builder->getMangaUid()}/v{$builder->getVolumeNumber()}/c{$builder->getChapterNumber()}";

        $results = $this->manager->requestMobile("GET", $url, []);
        
        $parser = new MangafoxScanParser($this->manager);

        return $parser->parse($results);
    }
}
