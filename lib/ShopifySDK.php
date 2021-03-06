<?php

/**
 * Created by PhpStorm.
 * @author Tareq Mahmood <tareqtms@yahoo.com>
 * Created at 8/16/16 10:42 AM UTC+06:00
 *
 * @see https://help.shopify.com/api/reference/ Shopify API Reference
 */

namespace PHPShopify;


/*
|--------------------------------------------------------------------------
| Shopify API SDK Client Class
|--------------------------------------------------------------------------
|
| This class initializes the resource objects
|
| Usage:
| //For private app
| $config = array(
|    'ShopUrl' => 'yourshop.myshopify.com',
|    'ApiKey' => '***YOUR-PRIVATE-API-KEY***',
|    'Password' => '***YOUR-PRIVATE-API-PASSWORD***',
| );
| //For third party app
| $config = array(
|    'ShopUrl' => 'yourshop.myshopify.com',
|    'AccessToken' => '***ACCESS-TOKEN-FOR-THIRD-PARTY-APP***',
| );
| //Create the shopify client object
| $shopify = new ShopifySDK($config);
|
| //Get shop details
| $products = $shopify->Shop->get();
|
| //Get list of all products
| $products = $shopify->Product->get();
|
| //Get a specific product by product ID
| $products = $shopify->Product($productID)->get();
|
| //Update a product
| $updateInfo = array('title' => 'New Product Title');
| $products = $shopify->Product($productID)->put($updateInfo);
|
| //Delete a product
| $products = $shopify->Product($productID)->delete();
|
| //Create a new product
| $productInfo = array(
|    "title" => "Burton Custom Freestlye 151",
|    "body_html" => "<strong>Good snowboard!<\/strong>",
|    "vendor" => "Burton",
|    "product_type" => "Snowboard",
| );
| $products = $shopify->Product->post($productInfo);
|
| //Get variants of a product (using Child resource)
| $products = $shopify->Product($productID)->Variant->get();
|
| //GraphQL
| $data = $shopify->GraphQL->post($graphQL);
|
*/

use PHPShopify\Exception\SdkException;

/**
 * @property-read AbandonedCheckout $AbandonedCheckout
 * @property-read ApplicationCharge $ApplicationCharge
 * @property-read Blog $Blog
 * @property-read CarrierService $CarrierService
 * @property-read Collect $Collect
 * @property-read Collection $Collection
 * @property-read Comment $Comment
 * @property-read Country $Country
 * @property-read Currency $Currency
 * @property-read CustomCollection $CustomCollection
 * @property-read Customer $Customer
 * @property-read CustomerSavedSearch $CustomerSavedSearch
 * @property-read Discount $Discount
 * @property-read DiscountCode $DiscountCode
 * @property-read DraftOrder $DraftOrder
 * @property-read Event $Event
 * @property-read FulfillmentService $FulfillmentService
 * @property-read GiftCard $GiftCard
 * @property-read InventoryItem $InventoryItem
 * @property-read InventoryLevel $InventoryLevel
 * @property-read Location $Location
 * @property-read Metafield $Metafield
 * @property-read Multipass $Multipass
 * @property-read Order $Order
 * @property-read Page $Page
 * @property-read Policy $Policy
 * @property-read Product $Product
 * @property-read ProductListing $ProductListing
 * @property-read ProductVariant $ProductVariant
 * @property-read PriceRule $PriceRule
 * @property-read RecurringApplicationCharge $RecurringApplicationCharge
 * @property-read Redirect $Redirect
 * @property-read Report $Report
 * @property-read ScriptTag $ScriptTag
 * @property-read ShippingZone $ShippingZone
 * @property-read Shop $Shop
 * @property-read SmartCollection $SmartCollection
 * @property-read ShopifyPayment $ShopifyPayment
 * @property-read Theme $Theme
 * @property-read User $User
 * @property-read Webhook $Webhook
 * @property-read GraphQL $GraphQL
 *
 * @method AbandonedCheckout AbandonedCheckout(integer $id = null)
 * @method ApplicationCharge ApplicationCharge(integer $id = null)
 * @method Blog Blog(integer $id = null)
 * @method CarrierService CarrierService(integer $id = null)
 * @method Collect Collect(integer $id = null)
 * @method Collection Collection(integer $id = null)
 * @method Comment Comment(integer $id = null)
 * @method Country Country(integer $id = null)
 * @method Currency Currency(integer $id = null)
 * @method CustomCollection CustomCollection(integer $id = null)
 * @method Customer Customer(integer $id = null)
 * @method CustomerSavedSearch CustomerSavedSearch(integer $id = null)
 * @method Discount Discount(integer $id = null)
 * @method DraftOrder DraftOrder(integer $id = null)
 * @method DiscountCode DiscountCode(integer $id = null)
 * @method Event Event(integer $id = null)
 * @method FulfillmentService FulfillmentService(integer $id = null)
 * @method GiftCard GiftCard(integer $id = null)
 * @method InventoryItem InventoryItem(integer $id = null)
 * @method InventoryLevel InventoryLevel(integer $id = null)
 * @method Location Location(integer $id = null)
 * @method Metafield Metafield(integer $id = null)
 * @method Multipass Multipass(integer $id = null)
 * @method Order Order(integer $id = null)
 * @method Page Page(integer $id = null)
 * @method Policy Policy(integer $id = null)
 * @method Product Product(integer $id = null)
 * @method ProductListing ProductListing(integer $id = null)
 * @method ProductVariant ProductVariant(integer $id = null)
 * @method PriceRule PriceRule(integer $id = null)
 * @method RecurringApplicationCharge RecurringApplicationCharge(integer $id = null)
 * @method Redirect Redirect(integer $id = null)
 * @method Report Report(integer $id = null)
 * @method ScriptTag ScriptTag(integer $id = null)
 * @method ShippingZone ShippingZone(integer $id = null)
 * @method Shop Shop(integer $id = null)
 * @method SmartCollection SmartCollection(integer $id = null)
 * @method Theme Theme(int $id = null)
 * @method User User(integer $id = null)
 * @method Webhook Webhook(integer $id = null)
 * @method GraphQL GraphQL()
 */
class ShopifySDK
{
    /**
     * List of available resources which can be called from this client
     *
     * @var string[]
     */
    protected $resources = array(
        'AbandonedCheckout',
        'ApplicationCharge',
        'Blog',
        'CarrierService',
        'Collect',
        'Collection',
        'Comment',
        'Country',
        'Currency',
        'CustomCollection',
        'Customer',
        'CustomerSavedSearch',
        'Discount',
        'DiscountCode',
        'DraftOrder',
        'Event',
        'FulfillmentService',
        'GiftCard',
        'InventoryItem',
        'InventoryLevel',
        'Location',
        'Metafield',
        'Multipass',
        'Order',
        'Page',
        'Policy',
        'Product',
        'ProductListing',
        'ProductVariant',
        'PriceRule',
        'RecurringApplicationCharge',
        'Redirect',
        'Report',
        'ScriptTag',
        'ShippingZone',
        'Shop',
        'SmartCollection',
        'ShopifyPayment',
        'Theme',
        'User',
        'Webhook',
        'GraphQL'
    );



    private Config $config;

    /**
     * List of resources which are only available through a parent resource
     *
     * @var array Array key is the child resource name and array value is the parent resource name
     */
    protected $childResources = array(
        'Article'           => 'Blog',
        'Asset'             => 'Theme',
        'CustomerAddress'   => 'Customer',
        'Fulfillment'       => 'Order',
        'FulfillmentEvent'  => 'Fulfillment',
        'OrderRisk'         => 'Order',
        'ProductImage'      => 'Product',
        'ProductVariant'    => 'Product',
        'DiscountCode'      => 'PriceRule',
        'Province'          => 'Country',
        'Refund'            => 'Order',
        'Transaction'       => 'Order',
        'UsageCharge'       => 'RecurringApplicationCharge',
    );

    /*
     * ShopifySDK constructor
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct(string $shopUrl, $config = [], $apiVersion = '2020-01')
    {
        $this->config = new Config($shopUrl, $config, $apiVersion);
    }

    /**
     * Return ShopifyResource instance for a resource.
     * @example $shopify->Product->get(); //Returns all available Products
     * Called like an object properties (without parenthesis)
     *
     * @param string $resourceName
     *
     * @return ShopifyResource
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * Return ShopifyResource instance for a resource.
     * Called like an object method (with parenthesis) optionally with the resource ID as the first argument
     * @example $shopify->Product($productID); //Return a specific product defined by $productID
     *
     * @param string $resourceName
     * @param array $arguments
     *
     * @throws SdkException if the $name is not a valid ShopifyResource resource.
     *
     * @return ShopifyResource
     */
    public function __call($resourceName, $arguments)
    {
        if (!in_array($resourceName, $this->resources)) {
            if (isset($this->childResources[$resourceName])) {
                $message = "$resourceName is a child resource of " . $this->childResources[$resourceName] . ". Cannot be accessed directly.";
            } else {
                $message = "Invalid resource name $resourceName. Pls check the API Reference to get the appropriate resource name.";
            }
            throw new SdkException($message);
        }

        $resourceClassName = __NAMESPACE__ . "\\$resourceName";

        //If first argument is provided, it will be considered as the ID of the resource.
        $resourceID = !empty($arguments) ? $arguments[0] : null;

        //Initiate the resource object
        $resource = new $resourceClassName($this, $resourceID);

        return $resource;
    }



    /**
     * Get the value of config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
