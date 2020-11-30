<?php

namespace PHPShopify;

use PHPShopify\Exception\ConfigNotFoundException;

class Config
{
    /**
     * @var string Default Shopify API version
     */
    private string $apiVersion;

    /**
     * @var string
     */
    private string $shopUrl;

    /**
     * @var string
     */
    private string $adminUrl;

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var array of additionnal configurations
     */
    private array $config;

    public function __construct(string $shopUrl, array $config = [], string $apiVersion)
    {
        $this->apiVersion = $apiVersion;
        $this->config = $config;
        $this->shopUrl = $shopUrl;
        $this->setAdminUrl($shopUrl);
    }

    public function getConfig(string $key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        throw new ConfigNotFoundException("Config $key don't exist");
    }

    public function hasConfig(string $key): bool
    {
        if (isset($this->config[$key])) {
            return true;
        }
        return false;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Set the admin url, based on the configured shop url
     *
     * @return string
     */
    private function setAdminUrl(string $shopUrl)
    {
        //Remove https:// and trailing slash (if provided)
        $shopUrl = preg_replace('#^https?://|/$#', '', $shopUrl);

        if (isset($this->config['ApiKey']) && isset($this->config['Password'])) {
            $apiKey = $this->config['ApiKey'];
            $apiPassword = $this->config['Password'];
            $adminUrl = "https://$apiKey:$apiPassword@$shopUrl/admin/";
        } else {
            $adminUrl = "https://$shopUrl/admin/";
        }

        $this->adminUrl = $adminUrl;
        $this->apiUrl = $adminUrl . "api/$this->apiVersion/";

        return $adminUrl;
    }

    /**
     * Get the value of shopUrl
     *
     * @return  string
     */
    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    /**
     * Get the value of adminUrl
     *
     * @return  string
     */
    public function getAdminUrl(): string
    {
        return $this->adminUrl;
    }

    /**
     * Get the value of apiUrl
     *
     * @return  string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }
}
