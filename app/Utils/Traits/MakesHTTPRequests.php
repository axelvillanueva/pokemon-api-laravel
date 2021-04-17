<?php

namespace App\Utils\Traits;

use GuzzleHttp\Client;

/**
 * An utility trait to wrap all the common http requests with guzzle
 */
trait MakesHTTPRequests
{
    /**
     * Gets a new instance of the guzzle client
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Makes an http request
     *
     * @param string $url
     * @param string $method The HTTP verb (POST, GET, PUT, DELETE)
     * @param array $headers Any extra headers to add to the request, in the form of an associative array ['header-key' => 'header-val']
     * @param array $params The request body. In case of a GET request, the params will be added as query params
     * @param array $auth Any extra auth data (To handle basic or digest auth)
     *
     * @return array The response in form of an array
     */
    public function makeRequest($url, $method, $headers = [], $params = [], $auth = [])
    {
        $body = [];
        if (! empty($params)) {
            if ($method == 'GET') {
                $body['query'] = $params;
            } else {
                $body['json'] = $params;
            }
        }
        if (! empty($headers)) {
            $body['headers'] = $headers;
        }
        if (! empty($auth)) {
            $body['auth'] = $auth;
        }
        $response = $this->getClient()
            ->request($method, $url, $body)
            ->getBody()
            ->getContents();

        return json_decode($response, true);
    }
}
