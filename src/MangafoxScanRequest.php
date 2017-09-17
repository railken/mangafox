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
        $url = $builder->getUrl() ? $builder->getUrl() : "/manga/{$builder->getMangaUid()}/v{$builder->getVolumeNumber()}/c{$builder->getChapterNumber()}/1.html";

        $scans = new Collection();

        do {
            $results = $this->manager->request("GET", $url, []);

            $parser = new MangafoxScanParser($this->manager);
            $scan = $parser->parse($results);


            $scans[] = $scan;
            $next = $scan->next;

            if (strpos($next, $this->manager->getUrl()) !== false) {
                $next = false;
            }

            $url = dirname($url)."/".$next;

            usleep(100000);
        } while ($next);

        return $scans;
    }
}
