<?php

namespace Railken\Mangafox;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

abstract class MangaReader implements MangaReaderContract
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->urls['app'],
            'cookies'  => CookieJar::fromArray([
                'isAdult' => '1',
            ], parse_url($this->urls['app'])['host']),
        ]);
    }

    /**
     * Send a request.
     *
     * @param string $method
     * @param string $url
     * @param array  $data
     */
    public function request($method, $url, $data, $retry = 1)
    {
        $params = [];
        $params['http_errors'] = false;
        // $params['debug'] = true;

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

        if ($response->getStatusCode() == '502' and $retry > 0) {
            sleep(10);

            return $this->request($method, $url, $data, $retry - 1);
        }

        if ($response->getStatusCode() != '200' and $retry > 0) {
            return $this->request($method, $url, $data, $retry - 1);
        }

        return $contents;
    }

    /**
     * Send a request.
     *
     * @param string $method
     * @param string $url
     * @param array  $data
     */
    public function requestMobile($method, $url, $data)
    {
        return $this->request($method, $this->urls['mobile'].$url, $data);
    }
}
