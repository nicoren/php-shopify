<?php
/*
 * Created on Mon Nov 30 2020
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2020 Tangkoko
 */

namespace PHPShopify;



class GuzzleClientGraphQl extends GuzzleClient
{
    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $httpHeaders
     * @param array $dataArray
     *
     * @return void
     */
    protected function prepareRequest(string $url, $httpHeaders = [], $dataArray = [], $variables = []): array
    {
        $headers = array_merge($httpHeaders, ['Content-type' => "application/json"]);
        $requestData =  [
            'headers' => $headers,
            'json' => [
                'query' => $dataArray,
                'variables' => $variables
            ]
        ];
        return $requestData;
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
    public function post($url, $dataArray, $httpHeaders = [], $variables = []): \Psr\Http\Message\ResponseInterface
    {
        $urlInfos = parse_url($url);
        $path = $urlInfos["path"];
        $data = $this->prepareRequest($url, $httpHeaders, $dataArray, $variables);
        $response = $this->guzzleClient->post($path, $data);
        return $response;
    }
}
