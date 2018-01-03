<?php

namespace Railken\Mangafox;

use GuzzleHttp\Client;

abstract class MangaReader implements MangaReaderContract
{

    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->urls['app']]);
    }

    /**
     * Send a request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     */
    public function request($method, $url, $data)
    {
        $params = [];
        $params['http_errors'] = false;

        switch ($method) {
            case 'POST': case 'PUT':
                $params['form_params'] = $data;

            break;

            default:
                $params['query'] = $data;
            break;
        }


        $response = $this->client->request($method, $url, $params);

        $contents = $response->getBody()->getContents();
        
        return $contents;
    }

    /**
     * Send a request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     */
    public function requestMobile($method, $url, $data)
    {
        return $this->request($method, $this->urls['mobile'].$url, $data);
    }
}
