<?php
/*
 * Created on Mon Nov 30 2020
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2020 Tangkoko
 */

namespace PHPShopify;


use GuzzleHttp\Client;

class GuzzleClient
{
    /**
     *
     * @var \GuzzleHttp\ClientInterface;
     */
    private $guzzleClient;

    public function __construct(Config $config)
    {
        $urlInfos = parse_url($config->getApiUrl());
        $this->guzzleClient = new Client([
            'base_uri' => "{$urlInfos["scheme"]}://{$urlInfos["host"]}/",
            'handler' => $config->hasConfig('handler') ? $config->getConfig('handler') : null
        ]);
    }


    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $httpHeaders
     * @param array $dataArray
     *
     * @return void
     */
    protected function prepareRequest(string $url, $httpHeaders = [], $dataArray = []): array
    {
        $urlInfos = parse_url($url);
        $headers = array_merge($httpHeaders, ['Content-type' => 'application/json']);
        parse_str($urlInfos["query"], $query);
        $requestData =  [
            'headers' => $headers,
            'query' => $query
        ];

        if (!empty($dataArray)) {
            $requestData['json'] = $dataArray;
        }
        return $requestData;
    }

    /**
     * Implement a GET request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public function get(string $url, $httpHeaders = []): \Psr\Http\Message\ResponseInterface
    {
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders);
        $response = $this->guzzleClient->get($path, $data);
        return $response;
    }

    /**
     * Implement a POST request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public function post($url, $dataArray, $httpHeaders = []): \Psr\Http\Message\ResponseInterface
    {
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders, $dataArray);
        $response = $this->guzzleClient->post($path, $data);
        return $response;
    }

    /**
     * Implement a PUT request and return json decoded output
     *
     * @param string $url
     * @param array $dataArray
     * @param array $httpHeaders
     *
     * @return array
     */
    public function put($url, $dataArray, $httpHeaders = []): \Psr\Http\Message\ResponseInterface
    {
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders, $dataArray);
        $response = $this->guzzleClient->put($path, $data);
        return $response;
    }

    /**
     * Implement a DELETE request and return json decoded output
     *
     * @param string $url
     * @param array $httpHeaders
     *
     * @return array
     */
    public function delete($url, $httpHeaders = []): \Psr\Http\Message\ResponseInterface
    {
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders);
        $response = $this->guzzleClient->delete($path, $data);
        return $response;
    }
}
