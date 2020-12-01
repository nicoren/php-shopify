<?php

/**
 * Created by PhpStorm.
 * User: Tareq
 * Date: 5/27/2019
 * Time: 12:36 PM
 *
 * @see https://help.shopify.com/en/api/graphql-admin-api GraphQL Admin API
 */

namespace PHPShopify;


use PHPShopify\Exception\ApiException;
use PHPShopify\Exception\CurlException;
use PHPShopify\Exception\SdkException;

class GraphQL extends ShopifyResource
{

    protected string $cursor;

    protected bool $hasNextPage;

    protected bool $hasPreviousPage;

    /**
     * @inheritdoc
     */
    protected function getResourcePath()
    {
        return 'graphql';
    }

    /**
     * Call POST method for any GraphQL request
     *
     * @param string $graphQL A valid GraphQL String. @see https://help.shopify.com/en/api/graphql-admin-api/graphiql-builder GraphiQL builder - you can build your graphql string from here.
     * @param string $url
     * @param bool $wrapData
     * @param array|null $variables
     *
     * @uses HttpRequestGraphQL::post() to send the HTTP request
     * @throws ApiException if the response has an error specified
     * @throws CurlException if response received with unexpected HTTP code.
     *
     * @return array
     */
    public function post($graphQL, $url = null, $wrapData = false, $variables = null)
    {
        if (!$url) $url = $this->generateUrl();
        $client = new GuzzleClientGraphQl($this->sdk->getConfig());
        $response = $client->post($url, $graphQL, $this->httpHeaders, $variables);
        return $this->processResponse($response);
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function get($urlParams = array(), $url = null, $dataKey = null)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function put($dataArray, $url = null, $wrapData = true)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }

    /**
     * @inheritdoc
     * @throws SdkException
     */
    public function delete($urlParams = array(), $url = null)
    {
        throw new SdkException("Only POST method is allowed for GraphQL!");
    }

    public function hasNextPage(): bool
    {
        return $this->hasNextPage;
    }

    public function hasPreviousPage(): bool
    {
        return $this->hasPreviousPage;
    }

    /**
     * Process the request response
     *
     * @param array $responseArray Request response in array format
     * @param string $dataKey Keyname to fetch data from response array
     *
     * @throws ApiException if the response has an error specified
     * @throws CurlException if response received with unexpected HTTP code.
     *
     * @return array
     */
    public function processResponse(\Psr\Http\Message\ResponseInterface $response, $dataKey = null)
    {
        $successHttpCodes = [200, 201, 204];
        $this->hasNextPage = false;
        $this->hasPreviousPage = false;
        //should be null if any other library used for http calls
        $httpCode = $response->getStatusCode();

        if ($httpCode != null && !in_array($httpCode, $successHttpCodes)) {
            throw new Exception\CurlException("Request failed with HTTP Code $httpCode.", $httpCode);
        }

        $responseArray = json_decode($response->getBody(), true);
        if (isset($responseArray['errors'])) {
            $message = $this->castString($responseArray['errors']);

            throw new ApiException($message, $httpCode);
        }

        if (isset($responseArray["data"])) {
            $results = [];
            $node = reset($responseArray["data"]);
            if (isset($node["pageInfo"])) {
                $pageInfo = $node["pageInfo"];
                $this->hasNextPage = (bool)$pageInfo["hasNextPage"];
                $this->hasPreviousPage = (bool)$pageInfo["hasPreviousPage"];
            }
            if (isset($node["edges"])) {
                $elements = $node["edges"];
                foreach ($elements as $element) {
                    $results[] = $element;
                }
            }
            return $results;
        }

        return $responseArray;
    }
}
