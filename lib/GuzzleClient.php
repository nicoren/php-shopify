<?php
/*
 * Created on Mon Nov 30 2020
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2020 Tangkoko
 */

namespace PHPShopify;


use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;

class GuzzleClient
{
    /**
     *
     * @var \GuzzleHttp\ClientInterface;
     */
    protected $guzzleClient;

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

        $requestData =  [
            'headers' => $headers
        ];

        if (!empty($urlInfos["query"])) {
            parse_str($urlInfos["query"], $query);
            $requestData['query'] = $query;
        }

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
        $method = __FUNCTION__;
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders);
        $response = $this->send($method, $path, $data);
        return $response;
    }

    protected function send($method, $path, $data)
    {
        $status = true;
        do {
            if (!$status) {
                usleep(500);
            }
            try {
                /**
                 * @var \Psr\Http\Message\ResponseInterface $response
                 */
                $response = $this->guzzleClient->$method($path, $data);
                $status = true;
            } catch (\Exception $e) {
                if ($e->getCode() == 429) {
                    $status = false;
                } else {
                    throw $e;
                }
            }
        } while ($status == false);

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
        $method = __FUNCTION__;
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders, $dataArray);
        $response = $this->send($method, $path, $data);
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
        $method = __FUNCTION__;
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders, $dataArray);
        $response = $this->send($method, $path, $data);
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
        $method = __FUNCTION__;
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders);
        $response = $this->send($method, $path, $data);
        return $response;
    }
}
